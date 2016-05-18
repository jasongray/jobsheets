<?php
/**
 * Job model.
 *
 * Job role model-related methods here.
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

/**
 * Job Model
 *
 */
class Job extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = '';

/**
 * Validation Rules
 *
 * @var void
 */
	public function validate_create_location() {
		$this->validate = array(
			'address_street' => array(
				'rule' => 'notBlank',
				'message' => __('An address must have a street name'),
				'required' => false,
			),
			'postcode_id' => array(
				'postcode' => array(
					'rule' => array('postcodeExists'),
					'message' => __('Please select a suburb from the dropdown list'),
					'last' => true,
					'required' => false,
				),
			),
		);
	}

	public function validate_create_customer() {
		$this->validate = array(
			'customer_id' => array(
				'customer' => array(
					'rule' => array('customerExists'),
					'message' => __('Please select a customer from the list or create a new customer record before continuing'),
					'last' => true,
					'required' => false,
				),
			),
		);
	} 

	public function remove_validation() {
		$this->validate = array();
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Client' => array(
			'className' => 'client',
			'foreignKey' => 'client_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'customer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'JobItem' => array(
			'className' => 'JobItem',
			'foreignKey' => 'job_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'JobLog' => array(
			'className' => 'JobLog',
			'foreignKey' => 'job_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);


	public function beforeSave($options = array()) {
		if (!isset($this->data['Job']['id']) && !$this->id) {
			$this->data['Job']['id'] = $this->generateID(time(), 0, false);
		}
		if (empty($this->data['Job']['client_id'])) {
			$this->data['Job']['client_id'] = CakeSession::read('Auth.User.client_id');
		}
		if (empty($this->data['Job']['client_meta'])) {
			$this->data['Job']['client_meta'] = CakeSession::read('Auth.User.client_meta');
		}
	    return true;

	}


/**
 * Generate a unique ID based on octal timestamp
 */
	private function generateID ($timestamp = false, $pad = 2, $base64 = false) {
		$code = false;
		if ($timestamp) {
			$hextime[] = substr($this->padstr(date('Y', $timestamp), 4), -2);
			$hextime[] = $this->padstr(decoct(date('m', $timestamp)));
			$hextime[] = $this->padstr(decoct(date('d', $timestamp)));
			$hextime[] = $this->padstr(decoct(date('H', $timestamp)));
			$hextime[] = $this->padstr(decoct(date('i', $timestamp)));
			$hextime[] = $this->padstr(decoct(date('s', $timestamp)));
			$code =  implode('', $hextime);
		}
		if ($base64) {
			$code = base64_encode($code);
		}
		return $code;
	}

/**
 * Pad a string by the given length
 */
	private function padstr($str, $len = 2) {
		return str_pad($str, $len, '0', STR_PAD_LEFT);
	} 	

/**
 * Check customer id exists when adding job
 *
 * @var $check Integar 
 * @return bool
 */
	public function customerExists($check) {
		if (!empty($check)) {
			App::uses('Customer', 'Model');
        	$this->Customer = new Customer();
			$this->Customer->recursive = -1;
			return $this->Customer->find('first', array(
				'conditions' => 
					array(
						'client_id' => CakeSession::read('Auth.User.client_id'),
						'client_meta' => CakeSession::read('Auth.User.client_meta'),
						'id' => $check['customer_id'],
					),
				)
			);
		}
		return false;
	}


/**
 * Check postcode id exists when adding job
 *
 * @var $check Integar 
 * @return bool
 */
	public function postcodeExists($check) {
		if (!empty($check)) {
			App::uses('Postcode', 'Model');
        	$this->Postcode = new Postcode();
			$this->Postcode->recursive = -1;
			return $this->Postcode->find('first', array(
				'conditions' => 
					array(
						'id' => $check['postcode_id'],
					),
				)
			);
		}
		return false;
	}

}
