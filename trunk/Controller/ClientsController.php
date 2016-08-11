<?php
/**
 * Clients controller.
 *
 * Obtain Clients from the database
 *
 * JobSheets : A tradies best friend (http://jobsheets.com.au)
 * Copyright (c) Webwidget Pty Ltd. (http://webwidget.com.au)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Webwidget Pty Ltd. (http://webwidget.com.au)
 * @link          http://jobsheets.com.au JobSheet Project
 * @package       JobSheet.Controller
 * @since         JobSheets v 0.0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');
/**
 * Clients Controller
 *
 */

class ClientsController extends AppController {

	public $components = array('Upload', 'PayPalSDK');

/**
 * Before Filter method
 *
 * callback function executed before the default method is called.
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
	}

/**
 * Client index method
 *
 * Displays list of customers based upon client index key. If no key and role is admin display all users.
 *
 * @return array  (Variable sent to the view will always be called data just to make things easier)
 */
	public function index() {
		$resp = $this->Client->getConditions();
		$this->paginate = $resp['paginate'];
		$this->set('data', $this->paginate());
		$this->render($resp['template']);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Client->create();
			if ($this->Client->save($this->request->data)) {
				$this->Flash->success('The client has been saved');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error('The client could not be saved. Please, try again.');
			}
		}
		$this->loadModel('Tax');
		$this->set('taxes', $this->Tax->find('list'));
		$this->set('plans', $this->Client->Plan->find('list'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Client->id = $id;
		if (!$this->Client->exists()) {
			throw new NotFoundException(__('Invalid client'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Client->save($this->request->data)) {
				$this->Flash->success('The client has been saved');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error('The client could not be saved. Please, try again.');
			}
		} else {
			$this->request->data = $this->Client->read(null, $id);
		}
		$this->loadModel('Tax');
		$this->set('taxes', $this->Tax->find('list'));
		$this->set('plans', $this->Client->Plan->find('list'));
	}

/**
 * Client account method
 *
 * Displays list of clients account information.
 *
 * @return array  (Variable sent to the view will always be called data just to make things easier)
 */
	public function account() {
		$this->Client->id = $this->Session->read('Auth.User.client_id');
		if (!$this->Client->isMine($this->Client->id, $this->Session->read('Auth.User.client_meta'))) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Client->save($this->request->data)) {
				$this->saveLogo($this->Client->id);
				$this->Flash->success(__('Your account information has been updated.'));
			} else {
				$this->Flash->error(__('There was an error. Please, try again.'));
			}
		}
		$this->request->data = $this->Client->findClient($this->Session->read('Auth.User.client_id'));
		$this->set('plans', $this->Client->Plan->getAllPlans());
		$this->loadModel('Tax');
		$this->set('taxes', $this->Tax->find('list'));
		$this->set('title_for_layout', __('My Account'));
	}

/**
 * subscribe to a plan method
 *
 * @return void
 */
	public function subscribe($planId = false) {
		$this->Client->id = $this->Session->read('Auth.User.Client.id');
		if (!$this->Client->exists()) {
			throw new NotFoundException(__('Invalid client'));
		}
		$plan = $this->Client->Plan->findByBillingPlanId($planId);
		if (!$plan) {
			throw new NotFoundException(__('Invalid plan'));	
		}
		if ($this->request->is('post')) {
			$this->Client->subscribe_validate();
			$this->Client->set($this->request->data['CC']);
			if ($this->Client->validates()){
				$data = $this->Client->read(null, $this->Client->id);
				$cc = isset($this->request->data['CC'])? $this->request->data['CC']: array();
				$agreement = $this->PayPalSDK->createAgreement($planId, $this->request->data['CC']['method'], $cc, $data);
				if ($agreement) {
					$this->Client->saveField('subscription_id', $argeement['id']);
					$this->Flash->success(__('Your billing agreement has been created. Thank you!'));
					if(!empty($agreement['link'])) {
						$this->redirect($agreement['link']);		
					}
				} else {
					$this->Flash->error(__('There was an error. Please, try again.'));
				}
			} else {
				$this->set('errors', $this->Client->validationErrors);
				$this->Flash->error(__('Please fix the errors below and try again.'));
			}
			unset($this->request->data);
		}
		$this->set(compact('plan'));
		$this->set('title_for_layout', __('Subscribe'));
	}

/**
 * deactivate method
 *
 * @return void
 */
	public function deactivate() {
		$this->Client->id = $this->Session->read('Auth.User.Client.id');
		if (!$this->Client->exists()) {
			throw new NotFoundException(__('Invalid client'));
		}
		$this->Client->saveField('status', 0);
		$this->Session->write('Auth.User.Client.status', 0);
		$this->redirect($this->referer());
	}

/**
 * save client logo
 *
 * @param string $id
 * @return void
 */	
	private function saveLogo($id = false) {
		if(isset($this->request->data['Image']['logo']) && $this->request->data['Image']['logo']['error'] != 4){
			$this->Upload->set('uploadDir', 'img' . DS . 'logo');
			$file = $this->Upload->process($this->request->data['Image']['logo']);
			if ($file) {
				$this->Client->id = $id;
				$this->Client->saveField('logo', 'logo' . DS . $file);
				$this->Session->write('Auth.User.Client.logo', 'logo' . DS . $file);
			} else {
				return false;
			}
		}
		return true;
	}

/**
 * removeAvatar method
 *
 * @param string $id
 * @return void
 */
	public function removeLogo($id = false) {
		if (!$this->Client->isMine($id, $this->Session->read('Auth.User.client_meta'))) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->layout = 'ajax';
		$this->render(false);
		$this->Flash->warning('Logo was not removed', true);
		if ($id) {
			$this->Client->id = $id;
			$logo = $this->Client->field('Client.logo');
			if ($file = new File(WWW_ROOT . 'img' . DS . $logo)) {
				$file->delete();
			}
			if ($this->Client->saveField('logo', '')) {
				$this->Flash->success('Logo was removed', true);
			}
		}
		$this->redirect($this->referrer());
	}

}
