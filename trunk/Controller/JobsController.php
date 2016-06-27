<?php
/**
 * Jobs controller.
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
 * @link          http://jobsheets.com.au JobSheet Project
 * @package       JobSheet.Controller
 * @since         JobSheets v 0.0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Jobs controller
 *
 * @package       JobSheet.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class JobsController extends AppController {

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
 * Job Calendar Display
 *
 * Displays current jobs in a calendar view...
 * If the user can edit the jobs then each job links to the edit page.
 *
 * @return array
 */
	public function calendar() {
		$role = $this->Session->read('Auth.User.role_id');
		$week['start'] = date('Y-m-d', strtotime('previous sunday'));
		$week['end'] = date('Y-m-d', strtotime('next saturday'));
		$week['today'] = date('Y-m-d', strtotime('today'));

		switch ($role) {
		 	case '1':
		 		# code...
		 		break;
		 	
		 	default:
		 		# code...
		 		break;
		}
		$this->set('data', $this->Job->calendardata($week['start'], $week['end']));

	}

/**
 * Job index method
 *
 * Displays list of current jobs based upon client index key. If no key and role is admin display all users.
 *
 * @return array  (Variable sent to the view will always be called data just to make things easier)
 */
	public function index() {
		$template = 'index';
		$this->Job->recursive = 2;

		$this->Job->unBindModel(array('hasMany' => array('JobItem')), false);
		$this->Job->Client->unBindModel(array('hasMany' => array('User')), false);
		$this->Job->Location->unBindModel(array('hasMany' => array('Job')), false);
		$this->Job->User->unBindModel(array('belongsTo' => array('Role', 'Client')), false);
		
		$role = $this->Session->read('Auth.User.role_id');
		$template = $this->Session->read('Auth.User.Client.template');
		if (isset($this->request->params['named']['status'])) {
			if ($this->request->params['named']['status'] == 'completed') {
				$JobStatus = array('Job.status' => 8);
			}
			if ($this->request->params['named']['status'] == 'cancelled') {
				$JobStatus = array('Job.status' => 9);
			}
			$class_status = $this->request->params['named']['status'];
		} else {
			$JobStatus = $JobStatus = array('Job.status <' => 8);
			$class_status = 'default';
		}

		switch ($role) {
			case 1:
				$this->paginate = array('limit' => 25, 'order' => array('Job.client_id ASC', 'Job.id DESC'));
				$template = 'admin_index';
				break;
			case 2:
			case 3:
				$this->paginate = array(
					'conditions' => array_merge(array(
						'Job.client_id' => $this->Session->read('Auth.User.client_id'),
						'Job.client_meta' => $this->Session->read('Auth.User.client_meta'),
						), $JobStatus
					),
					'limit' => 25, 
					'order' => array('Job.created ASC, Job.status ASC'),
				);
				$template = 'index';
				break;
			case 4:
			default:
				$this->paginate = array(
					'conditions' => array_merge(array(
						'Job.user_id' => $this->Session->read('Auth.User.id'),
						'Job.client_id' => $this->Session->read('Auth.User.client_id'),
						'Job.client_meta' => $this->Session->read('Auth.User.client_meta'),
						), $JobStatus
					),
					'limit' => 25, 
					'order' => array('Job.status ASC, Job.created ASC'),
				);
				$template = 'index_user';
				break;
		}

		$this->set('data', $this->paginate());
		$this->set(compact('class_status'));
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
		$this->Job->id = $id;
		if (!$this->Job->exists()) {
			throw new NotFoundException(__('Invalid job ID'));
		}
		if (!$this->request->is('ajax')) {
			$this->joblog($this->Job->id, __('Job viewed by user %s', $this->Session->read('Auth.User.id')));
		}
		$this->data = $this->Job->find('first', array('conditions' => array('Job.client_id' => $this->Session->read('Auth.User.client_id'), 'Job.client_meta' => $this->Session->read('Auth.User.client_meta'), 'Job.id' => $id)));
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
			$this->Job->remove_validation();
			if (!empty($this->request->data['Job']['customer'])) {
				$this->Job->set($this->request->data['Job']);
				$this->Job->validate_create_customer();
				if (!$this->Job->validates()) {
					if (isset($this->Job->validationErrors['customer_id'])) {
						$this->Job->invalidate('customer', $this->Job->validationErrors['customer_id'][0]);
					}
					$continue = false;
				} else {
					if (empty($this->request->data['Job']['suburb'])) {
						$this->request->data['Job'] = array_merge($this->request->data['Job'], $this->Job->Customer->getLocation($this->request->data['Job']['customer_id']));
					} else {
						$continue = $this->add_validate_location();
					}
				}
			} else {
				$this->Job->set($this->request->data['Job']);
				$continue = $this->add_validate_location();
			}
			if ($continue) {
				$this->Job->set($this->request->data['Job']);
				if ($this->Job->save($this->request->data)) {
					$this->joblog($this->Job->id, __('Job created'));
					$this->Flash->success(__('Location created and Job updated.'));
					$this->redirect(array('action' => 'edit', $this->Job->id));
				} else {
					$this->Flash->error(__('There was an error saving your data.'));
				}
			} else {
				$errors = $this->Job->validationErrors;
				$this->Flash->error(__('Could not create the Job. Please fix the errors below.'));
			}
		}
		$this->set('customers', $this->Job->Customer->find('list', array('conditions' => array('Customer.client_id' => $this->Session->read('Auth.User.client_id')))));
	}

/** 
 * Private (merely because this snippet of code is used twice to return the same data)
 * Validate the location from post data when creating a job
 *
 * @return bool
 */
	private function add_validate_location() {
		$this->Job->validate_create_location();
		if (!$this->Job->validates()) {
			if (isset($this->Job->validationErrors['postcode_id'])) {
				$this->Job->invalidate('suburb', $this->Job->validationErrors['postcode_id'][0]);
			}
			return false;
		} else {
			$this->request->data['Job']['location_id'] = $this->Job->Location->match($this->request->data['Job']);
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
		$this->Job->id = $id;
		if (!$this->Job->exists()) {
			throw new NotFoundException(__('Invalid job ID'));
		}
		if ($this->request->is('post') && $this->request->is('ajax')) {
			$this->Job->saveField($this->data['type'], date('Y-m-d h:i:s'));
			$this->joblog($this->Job->id, __('Job status updated to %s', $this->data['type']));
			if ($this->data['type'] == 'completed') {
				$this->Job->saveField('status', 8);
			}
		}

		$this->data = $this->Job->find('first', array('conditions' > array('Job.client_id' => $this->Session->read('Auth.User.client_id'), 'Job.client_meta' => $this->Session->read('Auth.User.client_meta'), 'Job.id' => $id)));
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
		$this->Job->id = $id;
		if (!$this->Job->exists()) {
			throw new NotFoundException(__('Invalid job ID'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['Job']['location_id'] = $this->Job->Location->match($this->request->data['Job']);
			if ($this->Job->saveAll($this->request->data)) {
				$this->joblog($this->Job->id, __('Job edited by user %s', $this->Session->read('Auth.User.id')));
				$this->Flash->success(__('Job updated.'));
				$this->redirect(array('action' => 'edit', $this->Job->id));
			} else {
				$this->Flash->error(__('Please fix any errors before continuing.'));
			}
		}
		$this->data = $this->Job->find('first', array('conditions' => array('Job.client_id' => $this->Session->read('Auth.User.client_id'), 'Job.client_meta' => $this->Session->read('Auth.User.client_meta'), 'Job.id' => $id)));
		$this->Job->User->virtualFields = array('fullname' => 'CONCAT(firstname, " ", lastname)');
		$this->set('users', $this->Job->User->find('list', array('fields' => array('id', 'fullname'), 'conditions' => array('User.client_id' => $this->Session->read('Auth.User.client_id')))));
	}

/**
 * Delete a job
 *
 * Deletes a job and all associated data
 *
 * @return void
 */
	public function delete($id = null) {
		$this->Job->id = $id;
		if (!$this->Job->exists()) {
			throw new NotFoundException(__('Invalid job id'));
		}
		$this->Job->unBindModel(array('hasMany' => array('JobLog')));
		$data = $this->Job->read(null, $id);
		if ($this->Job->delete($id, true)) {
			$this->joblog($id, __('Job deleted by user %s', $this->Session->read('Auth.User.id')), json_encode($data));
			$this->Flash->success(__('Job deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Flash->error(__('Job was not removed.'));
		$this->redirect(array('action' => 'edit', $this->Job->id));
	}

/**
 * Delete a job item
 *
 * Deletes a job item
 *
 * @return void
 */
	public function deletejobitem($id = null) {
		$return = json_encode(array('error' => __('Remove JobItem Error')));
		$this->Job->JobItem->id = $id;
		$data = $this->Job->JobItem->read(null, $id);
		if ($this->Job->JobItem->delete()) {
			$this->joblog($data['JobItem']['job_id'], __('Job Item deleted by user %s', $this->Session->read('Auth.User.id')), json_encode($data));
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
 * @param int $id Job id
 * @return void
 */
	public function reallocate($id) {
		$this->Job->id = $id;
		if (!$this->Job->exists()) {
			throw new NotFoundException(__('Invalid job id'));
		}
		$reset = array('status' => 1, 'onscene' => NULL, 'backon' => NULL, 'completed' => NULL, 'allocated' => date('Y-m-d h:i:s'));
		if ($this->Job->save($reset)) {
			$this->joblog($id, __('Job reallocated by user %s', $this->Session->read('Auth.User.id')));
			$this->Flash->success(__('Job reallocated'));
			$this->redirect(array('action' => 'edit', $id));
		}

	}

}
