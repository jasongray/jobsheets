<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

/**
 * Load global helpers
 *
 * @return void
 */
	public $helpers = array(
		'Flash',
	);

/**
 * Load components
 *
 * Auth component - autheticate using form and Blowfish hasher
 * ACL - to use ACL plugin and ACL rules
 * Session - ensure it loads
 * Cookie - when logging in we want to save a cookie for future logins
 * RequestHandler - makes life easier
 * Flash - the new flash message component
 *
 * @return void
 */
	public $components = array(
		'Auth' => array(
			'authenticate' => array(
				'Form' => array(
					'passwordHasher' => 'Blowfish',
					'fields' => array('username' => 'email')
				)
			),
			'authorize' => array('Actions'),
			'flash' => array(
				'element' => 'login_error',
				'key' => 'auth',
				'params' => array()
			),
			'authError' => false,
			'loginRedirect' => array('controller' => 'jobs', 'action' => 'index'),
		),
		'Acl',
		'Security',
		'Session',
		'Cookie',
		'RequestHandler',
		'Flash',
	);

/**
 * Before Filter method
 *
 * callback function executed before the default method is called.
 *
 * @return void
 */	
	public function beforeFilter() {
		parent::beforeFilter();

		$this->Cookie->name = 'JobSheets';
	    $this->Cookie->time = 7 * 24 * 60 * 60;    // 7 days
	    $this->Cookie->path = '/';
	    $this->Cookie->key = 'ao8]$E^d4y0t9194q64%9G_%0G1^B,Wemi1y.i5!m3+[V$_9*6./ex';
	    $this->Cookie->httpOnly = true;
	    $this->Cookie->type('aes');

	    $this->Security->blackHoleCallback = 'blackhole';
	}

/**
 * Before Render method
 *
 * callback function executed before rendering of the view.
 *
 * @return void
 */	
	public function beforeRender() {
		$session = $this->Session->read('Auth.User');
		if ($session) {
			if ($session['Client']['status'] == 0 && $this->action != 'account') {
				$this->Flash->error(__('Your account is no longer active. Please contact us directly.'));
				$this->redirect(array('controller' => 'clients', 'action' => 'account'));
			}
			if (isset($session['Client']['created']) && $session['Client']['acc'] == 'trial' && $this->action != 'account') {
				$startdate = new DateTime(date('Y-m-d', strtotime($session['Client']['created'])));
				$start_acc_date = strtotime($startdate->format('Y-m-d'));
				$enddate = $startdate->modify(sprintf('+%s day', $session['Client']['acc_days']));
				$end_acc_date = strtotime($enddate->format('Y-m-d'));
				$this->set(compact('start_acc_date', 'end_acc_date'));
				if (time() > $end_acc_date) {
					if ($session['role_id'] < 3) {
						$this->Flash->warning(__('Your trial account has expired. Please select one of our products to continue using JobSheets.'));
						$this->redirect(array('controller' => 'clients', 'action' => 'account'));
					} else {
						$this->Flash->errorLogin(__('Your trial account has expired. Please contact your employer.'));
						$this->redirect(array('controller' => 'users', 'action' => 'logout'));
					}
				}
			}
		}
	}
		
/**
 * Cancel method
 *
 * Generic cancel method
 *
 * @param string $id
 * @return void
 */
	public function cancel($id = null) {
		$this->Flash->info(__('Operation cancelled', true));
		$this->redirect(array('action' => 'index'));
	}

/**
 * Blackhole method
 *
 * callback function executed before rendering of the view.
 *
 * @return void
 */	
	public function blackhole($type) {
		//pr($type);
	}

/** 
 * Records a log history into the joblog table
 *
 * @param int $id Job id
 * @param string $str details of log information
 * @return void
 */
	public function joblog($id = null, $str = null, $data = array()) {
		$this->loadModel('JobLog');
		if ($id) {
			$e = new Exception;
			$_data = array(
				'job_id' => $id,
				'client_id' => $this->Session->read('Auth.User.client_id'),
				'user_id' => $this->Session->read('Auth.User.id'),
				'details' => $str,
				'data' => json_encode($data),
				'trace' => json_encode($e->getTraceAsString()),
			);
			$this->JobLog->save($_data);
		}
	}

}
