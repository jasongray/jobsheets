<?php
/**
 * Job Items controller.
 *
 * Handles all aspects of job items
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
class JobItemsController extends AppController {

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
 * Create job method
 *
 * Allows the user to create a job
 *
 * @return void
 */
	public function add() {
		$return = json_encode(array('error' => __('JobItem not added')));
		if ($this->request->is('post')) {
			$this->JobItem->create();
			if ($this->JobItem->save($this->request->data)) {
				$this->joblog($this->request->data['JobItem']['job_id'], __('Job Item added by user %s', $this->Session->read('Auth.User.id')), json_encode($this->request->data));
				$return = json_encode(array('success' => __('Success')));
			}
			if ($this->request->is('ajax')) {
				echo $return;
				$this->render(false);
			}
		}
		$this->set('job_id', $this->request->params['named']['job_id']);
	}

/**
 * Delete a job item
 *
 * Deletes a job item
 *
 * @return void
 */
	public function delete($id = null) {
		$return = json_encode(array('error' => __('Remove JobItem Error')));
		$this->JobItem->id = $id;
		$data = $this->JobItem->read(null, $id);
		if ($this->JobItem->delete()) {
			$this->joblog($data['JobItem']['job_id'], __('Job Item deleted by user %s', $this->Session->read('Auth.User.id')), json_encode($data));
			$return = json_encode(array('success' => __('Success')));
		}
		if ($this->request->is('ajax')) {
			echo $return;
			$this->render(false);
		}
		
	}

}
