<?php
/**
 * Roles controller.
 *
 * This file will control all aspects of users roles within this app
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
 * Roles Controller
 *
 * @property Role $Role
 */
class RolesController extends AppController {
	
	public function beforeFilter() {
	    parent::beforeFilter(); 
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Role->recursive = 0;
		$this->paginate = array('limit' => 20, 'order' => 'Role.id ASC');
		$this->set('roles', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Role->id = $id;
		if (!$this->Role->exists()) {
			throw new NotFoundException(__('Invalid role'));
		}
		$this->set('role', $this->Role->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Role->create();
			if ($this->Role->save($this->request->data)) {
				$this->Flash->success('The role has been saved');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error('The role could not be saved. Please, try again.');
			}
		}
		$parentRoles = $this->Role->ParentRole->find('list');
		$this->set(compact('parentRoles'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Role->id = $id;
		if (!$this->Role->exists()) {
			throw new NotFoundException(__('Invalid role'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Role->save($this->request->data)) {
				$this->Flash->success('The role has been saved');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error('The role could not be saved. Please, try again.');
			}
		} else {
			$this->request->data = $this->Role->read(null, $id);
		}
		$parentRoles = $this->Role->ParentRole->find('list');
		$this->set(compact('parentRoles'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Role->id = $id;
		if (!$this->Role->exists()) {
			throw new NotFoundException(__('Invalid role'));
		}
		if ($this->Role->delete()) {
			$this->Flash->success('Role deleted');
			$this->redirect(array('action' => 'index'));
		}
		$this->Flash->error('Role was not deleted');
		$this->redirect(array('action' => 'index'));
	}
}
