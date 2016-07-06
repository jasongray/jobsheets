<?php
/**
 * User model.
 *
 * User model-related methods here.
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
 * @package       JobSheet.Model
 * @since         JobSheets v 0.0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppModel', 'Model');
App::uses('CakeEmail', 'Network/Email');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
App::uses('Security', 'Utility');

/**
 * User model for JobSheets.
 *
 * @package       JobSheets.Model
 */

class User extends AppModel {

	private $key = 'N98a(8^7U2FDbS|HGKoN550m{4V50Jps';
	private $code = '%1$s-%2$s-%1$s-%3$s';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'email';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Client' => array(
			'className' => 'Client',
			'foreignKey' => 'client_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * Validation Rules
 *
 * @var void
 */
	public function validate_signup() {
		$this->validate = array(
			'email' => array(
				'rule' => 'email',
				'message' => __('Please enter a valid email address'),
				'required' => true,
			),
			'business' => array(
				'rule' => 'notBlank',
				'message' => __('Please enter your business name'),
				'required' => true,
			),
			'phone' => array(
				'rule' => array('phone', '/^0[0-8]\d{8}$/', 'au'),
				'message' => __('Please enter a valid phone number'),
				'required' => true,
			),
			'locale' => array(
				'rule' => 'notBlank',
				'message' => __('Please select your country'),
				'required' => true,
			),
		);
	}


	var $actsAs = array('Acl' => array('type' => 'requester'));
	
	function parentNode() {
		if (!$this->id && empty($this->data)) {
			return null;
		}
		if (isset($this->data['User']['role_id'])) {
			$role_id = $this->data['User']['role_id'];
		} else {
			$role_id = $this->field('role_id');
		}
		if (!$role_id) {
			return null;
		} else {
			return array('Role' => array('id' => $role_id));
		}
	}

	public function beforeSave($options = array()) {
		if (isset($this->data['User']['password']) && !empty($this->data['User']['password'])) {
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
	    } else {
			unset($this->data['User']['password']);
		}

	    return true;

	}

	public function create_account() {
		// set some user defaults
		$this->data['User']['role_id'] = 2; // basic admin role for general clients
		$this->data['User']['status'] = 0; // un verified status

		// generate SMS code
		$this->data['User']['smscode'] = $this->randomnumbers(6);

		// generate password
		$this->data['User']['password'] = $this->generatePassword(false, 7, 6);

		// set some client defaults
		$this->data['Client']['name'] = $this->data['User']['business'];
		$this->data['Client']['email'] = $this->data['User']['email'];
		$this->data['Client']['status'] = 0; // un verified status		
		$this->data['Client']['userlimit'] = 4; // trial user limit...		
		$this->data['Client']['acc'] = 'trial'; // trial status period
		$this->data['Client']['acc_days'] = 14; // trial days period

		// save client data and return the id
		if ($this->Client->save($this->data['Client'])) {
			$client = $this->Client->read(null, $this->Client->id);
			$this->data['User']['client_id'] = $client['Client']['id'];
			$this->data['User']['client_meta'] = $client['Client']['client_meta'];
			$_data = $this->data['User'];
			if ($this->save($this->data['User'])) {
				$_data = array_merge($_data, array('id' => $this->id));
				CakeSession::write('huijnklmsa', base64_encode(json_encode($_data)));
				return true;
			}
		}
		return false;
	}

	public function checkcode($data = array()) {
		$user = json_decode(base64_decode(CakeSession::read('huijnklmsa')), true);
		if ($this->find('first', array('conditions' => array('User.id' => $user['id'], 'User.smscode' => $data['User']['smscode'])))) {
			$this->id = $user['id'];
			$this->saveField('status', 1);
			return true;
		}
		return false;
	}

	public function underlimit() {
		$count = $this->find('count', array('conditions' => array('User.client_id' => CakeSession::read('Auth.User.client_id'))));
		if(intval($count) > intval(CakeSession::read('Auth.Client.userlimit'))) {
			return true;
		}
		return false;
	}

	public function decrypt($data = false, $login = false) {
		$_data = array();
		if ($data) {
			if (preg_match('/\-(.*)\-(.*)\-(.*)/', Security::rijndael(base64_decode($data), $this->key, 'decrypt'), $m, false, strlen($this->key))) {
				$_data['User']['email'] = $m[1];
				$_data['User']['password'] = $m[3];
			}
		}
		return $_data;
	}

	public function encrypt($data = false) {
		if ($data) {
			if (!is_array($data)) {
				$data = $this->read(null, $data);
			}
			return base64_encode(Security::rijndael(sprintf($this->code, $this->key, $data['User']['email'], $data['User']['password']), $this->key, 'encrypt'));
		}
		return false;
	}

	public function identify($user = array()) {
	 	if (!empty($user)) {
	 		$_user = $this->find('first', array('conditions' => array('User.email' => $user['User']['email'], 'User.password' => $user['User']['password'])));
	 		if (!empty($_user)) {
	 			unset($_user['User']['password']);
	 			$_out['User'] = $_user['User'];
	 			unset($_user['User']);
	 			$_out['User'] = array_merge($_out['User'], $_user);
	 			return $_out;
	 		}
	 	}
	 	return false;
	}

	public function onlineUsers() {
		$modelName = Configure::read('Session.handler.model');
		if (empty($modeName)) {
			$modelName = 'Session';
		}
		$this->unBindModel(array(
			'belongsTo' => array(
				'Role', 'Client',
			),
		));
		$this->bindModel(array(
			'hasOne' => array(
				$modelName => array(
					'className' => $modelName,
					'foreignKey' => 'user_id',
					'conditions' => array(
						"$modelName.expires >" => time(),
					),
				)	
			),
		));
		$this->virtualFields = array(
			'name' => 'IF(CONCAT_WS(" ", User.firstname, User.lastname) IS NULL, User.email, CONCAT_WS(" ", User.firstname, User.lastname))',
			'session' => "IF($modelName.id != '', $modelName.id, NULL)",
		);
		$results = $this->find('all', array(
			'fields' => array(
				'name',
				'avatar',
				'lastactive',
				'session',
			),
			'conditions' => array(
				'User.client_id' => CakeSession::read('Auth.User.client_id'), 
				'User.client_meta' => CakeSession::read('Auth.User.client_meta'),
			),
			'order' => 'User.id',
			'group' => 'User.id',
		));
		$this->virtualFields = array();
		return $results;
	}

/**
 * generate a set of random numbers
 *
 * @param integer $len The number of characters to generate
 * @return string $out
 */	
	private function randomnumbers($len = 6) {
	 	$out = '';
	 	$chars = '0123456789';
	 	for ($i=0; $i<$len; $i++) {
	 		$out .= ($i%2) ? $chars[mt_rand(4,8)] : $chars[mt_rand(0,9)];
	 	}
	 	return $out;
	}

/**
 * generatePassword method
 * 
 * Generates a random set of characters depending upon the parameters entered and saves to the user record.
 *
 * @param integer $uid The user id of the user to save the password
 * @param integer $length The number of characters to generate
 * @param integer $strength The strength of the password to generate. 1 being alpha only, 8 being alpha numeric with symbols.
 * @return string $password
 */		
	private function generatePassword($uid = false, $length = 10, $strength = 8) {
		
		$chars = 'aeubcsfghjklmnpqrstvwxyz';
		if ($strength & 1) {
			$chars .= 'BCDFGHJKLMNPRSTVWXYZ';
		}
		if ($strength & 2) {
			$chars .= "AEU";
		}
		if ($strength & 4) {
			$chars .= '1234567890';
		}
		if ($strength & 8) {
			$chars .= '@#$%!*_()^!?][{}|';
		}
		 
		$password = '';
		for ($i = 0; $i < $length; $i++) {
			$password .= $chars[mt_rand(0, strlen($chars)-1)];
		}
		if ($uid) {
			$this->id = $uid;
			$this->saveField('password', $password);
		}
		return $password;
		
	}

}
?>