<?php
/**
 * Plans controller.
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
 * Plans Controller
 *
 * @property Plan $Plan
 */
class PlansController extends AppController {

	public $components = array('PayPalSDK');
	
	public function beforeFilter() {
	    parent::beforeFilter(); 
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Plan->recursive = 0;
		$this->paginate = array('limit' => 20, 'order' => 'Plan.id ASC');
		$this->set('plans', $this->paginate());
	}

/**
 * activate a plan
 *
 * @param string $planId
 * @return bool
 */
	public function activate($planId = false) {
		$this->autoRender = false;
		if ($this->request->is('ajax')) { 
			if ($this->PayPalSDK->activatePlan($planId)){
				$data = $this->Plan->findByBillingPlanId($planId);
				$this->Plan->id = $data['Plan']['id'];
				$this->Plan->saveField('active', 1);
				echo json_encode(array('code' => '200', 'message' => 'success'));
			} else {
				echo json_encode(array('code' => '400', 'message' => 'error'));
			}
		}
	}

/**
 * deactivate a plan
 *
 * @param string $planId
 * @return bool
 */
	public function deactivate($planId = false) {
		$this->autoRender = false;
		if ($this->request->is('ajax')) { 
			//if ($this->PayPalSDK->activatePlan($planId, 'CREATED')){
				$data = $this->Plan->findByBillingPlanId($planId);
				$this->Plan->id = $data['Plan']['id'];
				$this->Plan->saveField('active', 1);
				echo json_encode(array('code' => '200', 'message' => 'success'));
			//} else {
			//	echo json_encode(array('code' => '400', 'message' => 'error'));
			//}
		}
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Plan->create();
			if ($this->Plan->save($this->request->data)) {
				if ($billingId = $this->PayPalSDK->createPlan($this->request->data)) {
					$this->Plan->saveField('billing_plan_id', $billingId);
					if ($this->request->data['Plan']['active'] == 1) {
						$this->PayPalSDK->activatePlan($billingId);
					}
				}
				$this->Flash->success('The plan has been saved');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error('The plan could not be saved. Please, try again.');
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Plan->id = $id;
		if (!$this->Plan->exists()) {
			throw new NotFoundException(__('Invalid plan'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Plan->save($this->request->data)) {
				if (empty($this->request->data['Plan']['billing_plan_id'])) {
					if ($billingId = $this->PayPalSDK->createPlan($this->request->data)) {
						$this->Plan->saveField('billing_plan_id', $billingId);
					}
				}
				if ($this->request->data['Plan']['active'] == 1) {
						$this->PayPalSDK->activatePlan($billingId);
					}
				$this->Flash->success('The plan has been saved');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error('The plan could not be saved. Please, try again.');
			}
		} else {
			$this->request->data = $this->Plan->read(null, $id);
			$this->set('plan_data', $this->PayPalSDK->getPlan($this->request->data['Plan']['billing_plan_id']));
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Plan->id = $id;
		if (!$this->Plan->exists()) {
			throw new NotFoundException(__('Invalid plan'));
		}
		$data = $this->Plan->read(null, $id);
		if ($this->Plan->delete()) {
			$this->PayPalSDK->deletePlan($data['Plan']['billing_plan_id']);
			$this->Flash->success('Plan deleted');
			$this->redirect(array('action' => 'index'));
		}
		$this->Flash->error('Plan was not deleted');
		$this->redirect(array('action' => 'index'));
	}
}
