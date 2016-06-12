<?php
/**
 * Quotes controller.
 *
 * Handles all aspects of job creation through to completion
 *
 * JobSheets : A tradies best friend (http://jobsheets.com.au)
 * Copyright (c) Webwidget Pty Ltd. (http://webwidget.com.au)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Webwidget Pty Ltd. (http://webwidget.com.au)
 * @link          http://jobsheets.com.au QuoteSheet Project
 * @package       JobSheets.Controller
 * @since         JobSheets v 0.0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Quotes controller
 *
 * @package       QuoteSheet.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class QuotesController extends AppController {

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
 * Quote index method
 *
 * Displays list of current jobs based upon client index key. If no key and role is admin display all users.
 *
 * @return array  (Variable sent to the view will always be called data just to make things easier)
 */
	public function index() {
		$template = 'index';
		$this->Quote->recursive = 2;

		$this->Quote->unBindModel(array('hasMany' => array('QuoteItem')), false);
		$this->Quote->Client->unBindModel(array('hasMany' => array('User')), false);
		$this->Quote->User->unBindModel(array('belongsTo' => array('Role', 'Client')), false);
		
		$role = $this->Session->read('Auth.User.role_id');
		$template = $this->Session->read('Auth.User.Client.template');

		switch ($role) {
			case 1:
				$this->paginate = array('limit' => 25, 'order' => array('Quote.client_id ASC', 'Quote.id DESC'));
				$template = 'admin_index';
				break;
			case 2:
			case 3:
				$this->paginate = array(
					'conditions' => array(
						'Quote.client_id' => $this->Session->read('Auth.User.client_id'),
						'Quote.client_meta' => $this->Session->read('Auth.User.client_meta'),
					),
					'limit' => 25, 
					'order' => array('Quote.created ASC, Quote.status ASC'),
				);
				$template = 'index';
				break;
			case 4:
			default:
				$this->paginate = array(
					'conditions' => array(
						'Quote.user_id' => $this->Session->read('Auth.User.id'),
						'Quote.client_id' => $this->Session->read('Auth.User.client_id'),
						'Quote.client_meta' => $this->Session->read('Auth.User.client_meta'),
					),
					'limit' => 25, 
					'order' => array('Quote.status ASC, Quote.created ASC'),
				);
				$template = 'index_user';
				break;
		}

		$this->set('data', $this->paginate());

		$this->render($template);
	}

/**
 * View job method
 *
 * Allows the user to edit a job
 *
 * @return void
 */
	public function view($id = null) {
		$this->Quote->id = $id;
		if (!$this->Quote->exists()) {
			throw new NotFoundException(__('Invalid quote ID'));
		}
		if (!$this->request->is('ajax')) {
			$this->joblog($this->Quote->id, __('Quote viewed by user %s', $this->Session->read('Auth.User.id')));
		}
		$this->data = $this->Quote->find('first', array('conditions' => array('Quote.client_id' => $this->Session->read('Auth.User.client_id'), 'Quote.client_meta' => $this->Session->read('Auth.User.client_meta'), 'Quote.id' => $id)));
		$this->Quote->QuoteItem->updateTotal($id);
	}

/**
 * Create job method
 *
 * Allows the user to create a job
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$continue = true;
			$this->Quote->remove_validation();
			if (!empty($this->request->data['Quote']['customer'])) {
				$this->Quote->set($this->request->data['Quote']);
				$this->Quote->validate_create_customer();
				if (!$this->Quote->validates()) {
					if (isset($this->Quote->validationErrors['customer_id'])) {
						$this->Quote->invalidate('customer', $this->Quote->validationErrors['customer_id'][0]);
					}
					$continue = false;
				} else {
					if (empty($this->request->data['Quote']['suburb'])) {
						$this->request->data['Quote'] = array_merge($this->request->data['Quote'], $this->Quote->Customer->getLocation($this->request->data['Quote']['customer_id']));
					} else {
						$continue = $this->add_validate_location();
					}
				}
			} else {
				$this->Quote->set($this->request->data['Quote']);
				$continue = $this->add_validate_location();
			}
			if ($continue) {
				$this->Quote->set($this->request->data['Quote']);
				if ($this->Quote->save($this->request->data)) {
					$this->Quote->updateTax($this->request->data);
					$this->Quote->QuoteItem->updateTotal($this->Quote->id);
					$this->joblog($this->Quote->id, __('Quote created'));
					$this->Flash->success(__('Quote updated.'));
					$this->redirect(array('action' => 'edit', $this->Quote->id));
				} else {
					$this->Flash->error(__('There was an error saving your data.'));
				}
			} else {
				$errors = $this->Quote->validationErrors;
				$this->Flash->error(__('Could not create the Quote. Please fix the errors below.'));
			}
		}
		$this->set('customers', $this->Quote->Customer->find('list', array('conditions' => array('Customer.client_id' => $this->Session->read('Auth.User.client_id')))));
		$this->loadModel('Tax');
		$this->set('taxes', $this->Tax->find('list'));
	}

/** 
 * Private (merely because this snippet of code is used twice to return the same data)
 * Validate the location from post data when creating a job
 *
 * @return bool
 */
	private function add_validate_location() {
		$this->Quote->validate_create_location();
		if (!$this->Quote->validates()) {
			if (isset($this->Quote->validationErrors['postcode_id'])) {
				$this->Quote->invalidate('suburb', $this->Quote->validationErrors['postcode_id'][0]);
			}
			return false;
		} else {
			$this->request->data['Quote']['location_id'] = $this->Quote->Location->match($this->request->data['Quote']);
		}
		return true;
	}

/**
 * Update job method
 *
 * Allows the user to update the status of a job
 *
 * @return void
 */
	public function update($id = null) {
		$this->Quote->id = $id;
		if (!$this->Quote->exists()) {
			throw new NotFoundException(__('Invalid job ID'));
		}
		if ($this->request->is('post') && $this->request->is('ajax')) {
			$this->Quote->saveField($this->data['type'], date('Y-m-d h:i:s'));
			$this->joblog($this->Quote->id, __('Quote status updated to %s', $this->data['type']));
			if ($this->data['type'] == 'completed') {
				$this->Quote->saveField('status', 8);
			}
		}

		$this->data = $this->Quote->find('first', array('conditions' > array('Quote.client_id' => $this->Session->read('Auth.User.client_id'), 'Quote.client_meta' => $this->Session->read('Auth.User.client_meta'), 'Quote.id' => $id)));
		$this->render('view');
	}


/**
 * Edit job method
 *
 * Allows the user to edit a job
 *
 * @return void
 */
	public function edit($id = null) {
		$this->Quote->id = $id;
		if (!$this->Quote->exists()) {
			throw new NotFoundException(__('Invalid job ID'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Quote->saveAll($this->request->data)) {
				$this->Quote->updateTax($this->request->data);
				$this->Quote->QuoteItem->updateTotal($this->Quote->id);
				$this->joblog($this->Quote->id, __('Quote edited by user %s', $this->Session->read('Auth.User.id')));
				$this->Flash->success(__('Quote updated.'));
				$this->redirect(array('action' => 'edit', $this->Quote->id));
			} else {
				$this->Flash->error(__('Please fix any errors before continuing.'));
			}
		}
		$this->data = $this->Quote->find('first', array('conditions' => array('Quote.client_id' => $this->Session->read('Auth.User.client_id'), 'Quote.client_meta' => $this->Session->read('Auth.User.client_meta'), 'Quote.id' => $id)));
		$this->Quote->User->virtualFields = array('fullname' => 'CONCAT(firstname, " ", lastname)');
		$this->set('users', $this->Quote->User->find('list', array('fields' => array('id', 'fullname'), 'conditions' => array('User.client_id' => $this->Session->read('Auth.User.client_id')))));
		$this->loadModel('Tax');
		$this->set('taxes', $this->Tax->find('list'));
	}

/**
 * Delete a job
 *
 * Deletes a job and all associated data
 *
 * @return void
 */
	public function delete($id = null) {
		$this->Quote->id = $id;
		if (!$this->Quote->exists()) {
			throw new NotFoundException(__('Invalid job id'));
		}
		$this->Quote->unBindModel(array('hasMany' => array('QuoteLog')));
		$data = $this->Quote->read(null, $id);
		if ($this->Quote->delete($id, true)) {
			$this->joblog($id, __('Quote deleted by user %s', $this->Session->read('Auth.User.id')), json_encode($data));
			$this->Flash->success(__('Quote deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Flash->error(__('Quote was not removed.'));
		$this->redirect(array('action' => 'edit', $this->Quote->id));
	}

/**
 * Delete a job item
 *
 * Deletes a job item
 *
 * @return void
 */
	public function deletejobitem($id = null) {
		$return = json_encode(array('error' => __('Remove QuoteItem Error')));
		$this->Quote->QuoteItem->id = $id;
		$data = $this->Quote->QuoteItem->read(null, $id);
		if ($this->Quote->QuoteItem->delete()) {
			$this->joblog($data['QuoteItem']['job_id'], __('Quote Item deleted by user %s', $this->Session->read('Auth.User.id')), json_encode($data));
			$return = true;
		}
		if ($this->request->is('ajax')) {
			echo json_encode(array('success' => __('Success')));
			$this->render(false);
		}
		
	}

/** 
 * Re-allocated and reset job
 *
 * @param int $id Quote id
 * @return void
 */
	public function reallocate($id) {
		$this->Quote->id = $id;
		if (!$this->Quote->exists()) {
			throw new NotFoundException(__('Invalid job id'));
		}
		$reset = array('status' => 1, 'onscene' => NULL, 'backon' => NULL, 'completed' => NULL, 'allocated' => date('Y-m-d h:i:s'));
		if ($this->Quote->save($reset)) {
			$this->joblog($id, __('Quote reallocated by user %s', $this->Session->read('Auth.User.id')));
			$this->Flash->success(__('Quote reallocated'));
			$this->redirect(array('action' => 'edit', $id));
		}

	}

}
