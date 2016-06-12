<?php
/**
 * Customers controller.
 *
 * Obtain Customers from the database
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
 * Customers Controller
 *
 */

class CustomersController extends AppController {
	
	public function beforeFilter() {
	    parent::beforeFilter(); 
	}

/**
 * get method
 *
 * @return void
 */
	public function get() {
		$this->autoRender = false;
		if ($this->request->is('ajax')  && $this->request->is('post')) {
			$result = $this->Customer->getCustomerString($this->request->data['search']);
			if ($result) {
				return json_encode($result);
			}
		}
		return null;
	}


/**
 * Create customer method
 *
 * Allows the user to create a customer
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Customer->create();
			if ($this->Customer->save($this->request->data)) {
				if ($this->request->is('ajax')) {
					echo json_encode(array('response' => 'success', 'code' => '200', 'data' => array(
						'Customer' => array(
							'id' => $this->Customer->id,
							'name' => $this->request->data['Customer']['name'],
							)
						),
					));
					$this->render(false);
				} else {
					$this->Flash->success(__('Customer added.'));
					$this->redirect(array('action' => 'edit', $this->Customer->id));
				}
			} else {
				if ($this->request->is('ajax')) {
					echo json_encode(array('response' => 'error', 'code' => '404', 'data' => array(), 'message' => __('Please fix any errors before continuing.')));
					$this->render(false);
				} else {
					$this->Flash->error(__('Please fix any errors before continuing.'));
				}
			}
		}
	}

/**
 * Edit job method
 *
 * Allows the user to edit a job
 *
 * @return void
 */
	public function edit($id = null) {
		$this->Customer->id = $id;
		if (!$this->Customer->exists()) {
			throw new NotFoundException(__('Invalid job ID'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Customer->saveAll($this->request->data)) {
				$this->Flash->success(__('Customer updated.'));
				$this->redirect(array('action' => 'edit', $this->Customer->id));
			} else {
				$this->Flash->error(__('Please fix any errors before continuing.'));
			}
		}
	}

/**
 * Delete a job
 *
 * Deletes a job and all associated data
 *
 * @return void
 */
	public function delete($id = null) {
		$this->Customer->id = $id;
		if (!$this->Customer->exists()) {
			throw new NotFoundException(__('Invalid page'));
		}
		if ($this->Customer->delete()) {
			$this->Flash->success(__('Customer deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Flash->error(__('Customer was not removed.'));
		$this->redirect(array('action' => 'edit', $this->Customer->id));
	}


}
