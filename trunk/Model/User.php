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

	public function decrypt($data = false) {
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
			$passwordHasher = new BlowfishPasswordHasher();
			return base64_encode(Security::rijndael(sprintf($this->code, $this->key, $data['email'], $passwordHasher->hash($data['password'])), $this->key, 'encrypt'));
		}
		return false;
	}

}
?>