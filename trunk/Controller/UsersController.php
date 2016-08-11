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
App::uses('CakeEmail', 'Network/Email');
/**
 * Users controller
 *
 * @package       JobSheet.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController {

	public $components = array('Upload');

/**
 * Before Filter method
 *
 * callback function executed before the default method is called.
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('register', 'verify', 'forgot', 'captcha', 'reset', 'logout', 'session'));
	}

/**
 * Register method
 *
 * Users can register for an account. They will receive a verification SMS using the Esendex API before the account is setup.
 *
 * @return void
 */
	public function register () {
		$this->layout = 'login';
		if ($this->request->is('post')) {
			$this->User->set($this->request->data);
			$this->User->validate_signup();
			if ($this->User->validates()) {
				if ($this->User->create_account()) {
					$user = json_decode(base64_decode($this->Session->read('huijnklmsa')), true);
					$this->SMS = $this->Components->load('SMS');
					$this->SMS->init();
					$this->SMS->send($user['phone'], __('Your JobSheets verification code is ') . $user['smscode']);
					//$this->SMS->send('0423038000', __('New user registered'));
					$this->redirect(array('controller' => 'users', 'action' => 'verify'));
				}
			} else {
				$errors = $this->User->validationErrors;
				$this->Flash->error(__('Please correct any errors and try again'));
			}
		}
		$this->loadModel('Region');
		$this->set('locales', $this->Region->find('list', array('fields' => array('alpha-2', 'name'))));
		if (empty($this->data)) {
			$this->data = array('User' => array('locale' => 'AU'));
		}
		$this->set('title_for_layout', __('Register to use JobSheets'));
	}

/**
 * Verify sms code and send credentials to new client
 *
 * @return void
 */
	public function verify () {
		$this->layout = 'login';
		if ($this->request->is('post')) {
			if ($this->User->checkcode($this->request->data)) {
				$user = json_decode(base64_decode($this->Session->read('huijnklmsa')), true);
				$email = new CakeEmail('smtp');
				$email->template('welcome', 'default');
				$email->domain('jobsheets.com.au');
				$email->emailFormat('both');
				$email->to($user['email']);
				$email->subject(__('Welcome to JobSheets - Online job management software'));
				$email->viewVars(compact('user'));
				if ($email->send()) {
					$this->Flash->loginSuccess(__('You will receive an email with your login details. Please check the email account you registered with us.'));
					$this->Session->delete('huijnklmsa');
					$this->redirect(array('controller' => 'users', 'action' => 'login'));
				}
			} else {
				$this->Flash->loginWarning(__('Incorrect verification code. Please try again'));
				$this->data = null;
			}
		}
		$this->set('title_for_layout', __('Verify your account'));
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
				$this->Cookie->write('session', $this->User->encrypt($this->User->id));
				if (empty($this->Session->read('Auth.User.lastactive')) && $this->Session->read('Auth.User.role_id') < 3) {
					$this->Flash->info(__('Complete your profile information.'));
					return $this->redirect(array('controller' => 'clients', 'action' => 'account'));
				} else {
					return $this->redirect($this->Auth->redirectUrl());
				}
			} else {
				$this->Flash->loginError(__('Incorrect Username and/or Password.'));
				$this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
		} else {
			$_session = $this->Session->read('Auth.User.id');
	    	if (empty($_session)) { 
				$_cookie = $this->Cookie->read('session');
				if (isset($_cookie) && !empty($_cookie)) {
					$user = $this->User->identify($this->User->decrypt($_cookie));
					if ($this->Auth->login($user['User'])) {
						$this->User->id = $this->Session->read('Auth.User.id');
						$this->User->saveField('lastactive', date('Y-m-d H:i:s'));
						$this->Cookie->write('session', $this->User->encrypt($this->User->decrypt($_cookie)));
						return $this->redirect($this->Auth->redirectUrl());
					} else {
						$this->Session->destroy('Auth.User');
						$this->Cookie->destroy('session');
						$this->redirect($this->Auth->logout());
					}
				}
			}
		}
		$this->set('title_for_layout', __('Login to use JobSheets'));
	}

/**
 * Refresh captcha
 *
 * @return void
 */
	public function captcha () {
		$this->helpers[] = 'Captcha';
		$this->layout = 'ajax';
	}

/**
 * Reset a user password stage one
 *
 * @return void
 */
	public function forgot () {
		$this->helpers[] = 'Captcha';
		$this->layout = 'login';
		if ($this->request->is('post')) {
			$_captcha = $this->Session->read('Reset.captcha_code');
			if ($_captcha === $this->request->data['User']['captcha']) {
				if ($user = $this->User->findByEmail($this->request->data['User']['email'])) {
					$user['User']['resetcode'] = $this->User->generateResetCode($user);
					$email = new CakeEmail('smtp');
					$email->template('forgot', 'default');
					$email->domain('jobsheets.com.au');
					$email->emailFormat('both');
					$email->to($user['User']['email']);
					$email->subject(__('Reset your password. JobSheets - Online job management software'));
					$email->viewVars(compact('user'));
					if ($email->send()) {
						$this->Flash->loginSuccess(__('A password reset link has been sent to your email address.'));
						$this->data = null;
					}
				} else {
					$this->Flash->loginWarning(__('That email address wass not found. Please try again.'));
					$this->data = null;
				}
			} else {
				$this->Flash->loginError(__('Incorrect code. Please try again.'));
				$this->data = null;
			}
		}
		
		$this->set('title_for_layout', __('Reset your password'));
	}

/**
 * Reset a user password
 *
 * @return void
 */
	public function reset ($resetcode = false) {
		if ($this->Session->check('Auth.User.id')) {
			$this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
		}
		$this->layout = 'login';
		if (!$resetcode) {
			$this->Flash->loginError(__('Something went wrong.'));
			$this->redirect(array('controller' => 'users', 'action' => 'forgot'));
		}
		if (!$this->User->checkResetCode($resetcode)) {
			$this->Flash->loginError(__('Your code has expired. Please try again.'));
			$this->redirect(array('controller' => 'users', 'action' => 'forgot'));
		}
		if ($this->request->is('post')) {
			$this->User->validate_reset();
			if ($this->User->validates()) {
				$this->User->saveNewPassword($resetcode, $this->request->data['User']['cpassword']);
				$this->Flash->loginSuccess(__('Your password has been successfully updated. Please login using this new password.'));
				$this->redirect(array('controller' => 'users', 'action' => 'login'));
			} else {
				$this->Flash->loginError(__('Please check the errors below and try again.'));
			}
		}
		$this->set('title_for_layout', __('Reset your password'));
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
		
		$invoice = array('total' => 0, 'lastweek' => 0);

		$online = $this->User->onlineUsers();

		$this->loadModel('Quote');
		$quotes = $this->Quote->outstanding();

		$this->loadModel('Job');
		$calendar = $this->Job->calendardata();
		$current = $this->Job->current();
		$jobs = $this->Job->outstanding();

		$this->loadModel('Sysmsg');
		$messages = $this->Sysmsg->find('all', array('conditions' => array('Sysmsg.status' => 1), 'order' => 'Sysmsg.created DESC'));

		$this->set(compact('invoice', 'jobs', 'quotes', 'calendar', 'messages', 'current', 'online'));
		$this->set('title_for_layout', __('My Dashboard'));
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
 * Profile user method
 *
 * @param string $id
 * @return void
 */
	public function profile() {
		$this->User->id = $this->Session->read('Auth.User.id');
		if (!$this->User->isMine($this->User->id, $this->Session->read('Auth.User.client_meta'))) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->saveAll($this->data)) {
				if (!$this->saveAvatar()) {
					$this->Flash->warning(__('User avatar not uploaded. ' . $this->Upload->getErrors(''), true));
				}
				if (!$this->saveLogo($this->Session->read('Auth.User.client_id'))) {
					$this->Flash->warning(__('Client logo not uploaded. ' . $this->Upload->getErrors(''), true));
				}
				$this->Flash->success(__('Your profile information has been updated.'));
			} else {
				$this->Flash->error(__('There was an error. Please, try again.'));
			}
		}
		$this->data = $this->User->read(null, $this->User->id);
		$this->set('title_for_layout', __('My Profile'));
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
		if (!$this->User->underlimit()) {
			$this->Flash->error(__('You have reached your allowed user limit. To increase your user limit visit your account page and update your subscription.'));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		if ($this->request->is('post')) {
			$this->User->validate_add();
			if ($this->User->save($this->request->data)) {
				if ($this->saveAvatar($this->User->id)) {
					$this->Flash->success(__('The user has been saved'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->warning(__('User avatar was not uploaded. ' . $this->Upload->getErrors(''), true));
				}
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
			$this->set('clients', $this->User->Client->find('list', array('conditions' => array('Client.id' => $this->Session->read('Auth.User.client_id')))));
		}
		$this->set(compact('roles'));
		$this->set('title_for_layout', __('Create User'));
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
			if (!empty($this->request->data['User']['password'])) {
				$this->User->validate_passgeneral();
			}
			if ($this->User->save($this->data)) {
				if ($this->saveAvatar($id)) {
					$this->Flash->success(__('The user has been saved'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Flash->warning(__('User avatar was not uploaded. ' . $this->Upload->getErrors(''), true));
				}
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
				$roles = $this->User->Role->find('list', array('conditions' => array('Role.id >= ' => $role)));
				$this->set('clients', $this->User->Client->find('list', array('conditions' => array('Client.id' => $this->Session->read('Auth.User.client_id')))));
			}
			$this->set(compact('roles'));
		}
		$this->set('title_for_layout', __('Edit User').sprintf(' %s', $id));
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
			$this->Upload->set('uploadDir', 'img' . DS . 'users');
			$file = $this->Upload->process($this->request->data['Image']['file']);
			if ($file) {
				if ($id == $this->Session->read('Auth.User.id')) {
					$this->Session->write('Auth.User.avatar', 'users' . DS . $file);
				}
				$this->User->saveField('avatar', 'users' . DS . $file);
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
				if ($id == $this->Session->read('Auth.User.id')) {
					$this->Session->write('Auth.User.avatar', '');
				}
				$this->Flash->success('Image was removed', true);
			}
		}
		$this->redirect(array('action' => 'edit', $id));
	}

// Client logo methods

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
				$this->User->Client->id = $id;
				$this->User->Client->saveField('logo', 'logo' . DS . $file);
				$this->Session->write('Auth.Client.logo', 'logo' . DS . $file);
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
		if (!$this->User->isMine($id, $this->Session->read('Auth.User.client_meta'))) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->layout = 'ajax';
		$this->render(false);
		$this->Flash->warning('Logo was not removed', true);
		if ($id) {
			$this->User->Client->id = $id;
			$logo = $this->User->Client->field('Client.logo');
			if ($file = new File(WWW_ROOT . 'img' . DS . 'logo' . DS . $logo)) {
				$file->delete();
			}
			if ($this->User->Client->saveField('logo', '')) {
				$this->Flash->success('Logo was removed', true);
			}
		}
		$this->redirect(array('action' => 'profile'));
	}

}