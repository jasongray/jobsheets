<?php
/**
 * Users controller.
 *
 * This file will control all aspects of users within this app
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
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Users controller
 *
 * @package       JobSheet.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController {

/**
 * Before Filter method
 *
 * callback function executed before the default method is called.
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('logout'));
	}

/**
 * Login method
 *
 * Login users, save values into cookies and redirect to the appropriate spot. 
 * If first time log in for a customer... then redirect the user to setup client information.
 *
 * @return void
 */
	public function login() {
		$this->layout = 'login';
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				if ($this->Session->read('Auth.User.status') == 0) {
					$this->Flash->loginWarning(__('Your account is not active. Please try again soon, if that fails please contact us directly.'));
					$this->redirect($this->Auth->logout());
					return;
				}
				$this->User->id = $this->Session->read('Auth.User.id');
				$this->User->saveField('lastactive', date('Y-m-d H:i:s'));
				$this->Cookie->write('session', $this->User->encrypt($this->request->data['User']));
				return $this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Flash->loginError(__('Incorrect Username and/or Password.'));
				$this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
		} else {
			$cookie = $this->Cookie->read('session');
			pr($cookie);
			if (isset($cookie) && !empty($cookie)) {
				$this->request->data = $this->User->decrypt($this->Cookie->read('session'));
				if ($this->Auth->login()) {
					$this->User->id = $this->Session->read('Auth.User.id');
					$this->User->saveField('lastactive', date('Y-m-d H:i:s'));
					$this->Cookie->write('session', $this->User->encrypt($this->request->data['User']));
					return $this->redirect($this->Auth->redirectUrl());
				} else {
					$this->Session->destroy('Auth.User');
					$this->Cookie->destroy('session');
					$this->redirect($this->Auth->logout());
				}
			}
		}

	}

/**
 * Logout method
 *
 * Logs user out an destroys cookie values
 *
 * @return void
 */
	public function logout() {
		$this->Flash->loginSuccess('You are now logged out!');
		$this->Session->destroy('Auth.User');
		$this->Cookie->destroy('session');
		$this->redirect($this->Auth->logout());
	}


/**
 * Dashboard method
 *
 * The user's dashboard
 *
 * @return void
 */
	public function dashboard() {
		
		// TO DO - add stuff here!
		
	}

/**
 * User index method
 *
 * Displays list of current users based upon client index key. If no key and role is admin display all users.
 *
 * @return array  (Variable sent to the view will always be called data just to make things easier)
 */
	public function index() {
		$this->User->recursive = 0;
		$role = $this->Session->read('Auth.User.role_id');
		if ($role === '1') {
			$this->User->unBindModel(array('belongsTo' => array('Client')), false);
			$this->paginate = array('limit' => 25, 'order' => array('User.client_id', 'User.lastname ASC'));
		} else {
			$this->paginate = array(
				'conditions' => array(
					'User.client_id' => $this->Session->read('Auth.User.client_id'),
				),
				'limit' => 25, 
				'order' => array('User.client_id', 'User.lastname ASC')
			);
		}
		$this->set('data', $this->paginate());
	}


/**
 * View user method
 *
 * Shows the user information when a user cannot edit a user
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->isMine($id, $this->Session->read('Auth.User.client_meta'))) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('data', $this->User->read(null, $id));
	}

/**
 * Add user method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->saveAvatar($this->User->id);
				$this->Flash->success(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		$role = $this->Session->read('Auth.User.role_id');
		if ($role === '1') {
				$this->set('clients', $this->User->Client->find('list'));
				$roles = $this->User->Role->find('list');				
		} else {
			$roles = $this->User->Role->find('list', array('conditions' => array('Role.id > ' => $role)));
		}
		$this->set(compact('roles'));
	}

/**
 * Edit user method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->isMine($id, $this->Session->read('Auth.User.client_meta'))) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->data)) {
				$this->saveAvatar($this->User->id);
				$this->Flash->success(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->data = $this->User->read(null, $id);
			$role = $this->Session->read('Auth.User.role_id');
			if ($role != '1' && $role > $this->data['User']['role_id']) {
				$this->Flash->warning(__('Cannot edit this users information'));
				$this->redirect(array('action' => 'view', $id));
			}
			if ($role === '1') {
				$this->set('clients', $this->User->Client->find('list'));
				$roles = $this->User->Role->find('list');				
			} else {
				$roles = $this->User->Role->find('list', array('conditions' => array('Role.id > ' => $role)));
				$this->set('clients', $this->User->Client->find('list', array('conditions' => array('Client.id' => $this->Session->read('Auth.User.client_id')))));
			}
			$this->set(compact('roles'));
		}
	}

/**
 * Delete user method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->isMine($id, $this->Session->read('Auth.User.client_meta'))) {
			throw new NotFoundException(__('Invalid user'));
		}
		$data = $this->User->read(null, $id);
		$role = $this->Session->read('Auth.User.role_id');
		if ($role > $data['User']['role_id']) {
			$this->Flash->warning(__('Cannot delete this users information'));
			$this->redirect(array('action' => 'index'));
			return;
		}
		if ($this->User->delete()) {
			$this->Flash->success(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Flash->error(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
/**
 * saveAvatar method
 *
 * @param string $id
 * @return void
 */	
	private function saveAvatar($id = false) {
		if(isset($this->request->data['Image']['file']) && $this->request->data['Image']['file']['error'] != 4){
			$temp = $this->data['Image']['file']['tmp_name'];
			$tdir = WWW_ROOT . 'img' . DS . 'users';
			$dir = new Folder($tdir, true, 0766);
			$file = pathinfo($this->request->data['Image']['file']['name']);
			$target = time() . md5($this->data['Image']['file']['name']) . '.' . $file['extension'];
			if(move_uploaded_file($temp, $tdir . DS . $target)){
				$this->User->saveField('avatar', 'users' . DS . $target);
				$this->Session->write('Auth.User.avatar', 'users' . DS . $target);
			} else {
				$this->Flash->warning(__('User avatar was not uploaded', true));
			}
			
		}
	}

/**
 * removeAvatar method
 *
 * @param string $id
 * @return void
 */
	public function removeAvatar($id = false) {
		if (!$this->User->isMine($id, $this->Session->read('Auth.User.client_meta'))) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->layout = 'ajax';
		$this->render(false);
		$this->Flash->warning('User avatar was not removed', true);
		if ($id) {
			$data = $this->User->read('avatar', $id);
			if ($file = new File(WWW_ROOT . 'img' . DS . $data['User']['avatar'])) {
				$file->delete();
			}
			if ($this->User->saveField('avatar', '')) {
				$this->Session->write('Auth.User.avatar', '');
				$this->Flash->success('Image was removed', true);
			}
		}
		//$this->redirect(array('action' => 'edit', $id));
	}

}