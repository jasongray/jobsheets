<?php
/**
 * Quote model.
 *
 * Quote role model-related methods here.
 *
 * JobSheets : A tradies best friend (http://quotesheets.com.au)
 * Copyright (c) Webwidget Pty Ltd. (http://webwidget.com.au)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Webwidget Pty Ltd. (http://webwidget.com.au)
 * @link          http://quotesheets.com.au QuoteSheet Project
 * @package       QuoteSheet.Model
 * @since         QuoteSheets v 0.0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppModel', 'Model');

/**
 * Quote Model
 *
 */
class Quote extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = '';

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
		'QuoteItem' => array(
			'className' => 'QuoteItem',
			'foreignKey' => 'quote_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * Validation Rules
 *
 * @var void
 */
	public function validate_create_location() {
		$this->validate = array(
			'address' => array(
				'rule' => 'notBlank',
				'message' => __('Please include an address'),
				'required' => false,
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

	public function beforeSave($options = array()) {
		if (!isset($this->data['Quote']['id']) && !$this->id) {
			$this->data['Quote']['id'] = $this->generateID(time(), 0, false);
		}
		if (empty($this->data['Quote']['client_id'])) {
			$this->data['Quote']['client_id'] = CakeSession::read('Auth.User.client_id');
		}
		if (empty($this->data['Quote']['client_meta'])) {
			$this->data['Quote']['client_meta'] = CakeSession::read('Auth.User.client_meta');
		}
		if (empty($this->data['Quote']['user_id'])) {
			$this->data['Quote']['user_id'] = CakeSession::read('Auth.User.id');
		}
	    return true;

	}


/**
 * Generate a unique ID based on octal timestamp
 */
	private function generateID ($timestamp = false, $pad = 2, $base64 = false) {
		$code = false;
		if ($timestamp) {
			$hextime[] = $this->padstr(date('Y', $timestamp), $pad);
			$hextime[] = $this->padstr(decoct(date('m', $timestamp)));
			//$hextime[] = $this->padstr(decoct(date('d', $timestamp)));
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

/**
 * Update tax rate into Quote table
 *
 * @var $data Array 
 * @return void
 */
	public function updateTax($data = array()) {
		if (!empty($data) && !empty($data['Quote']['tax_id'])) {
			App::uses('Tax', 'Model');
			$this->Tax = new Tax();
			$t = $this->Tax->read(null, $data['Quote']['tax_id']);
			if (!empty($t)) {
				$this->id = $data['Quote']['id'];
				$this->saveField('tax_rate', $t['Tax']['rate']);
				$this->saveField('tax_name', $t['Tax']['name']);
			}

		}
	}

}
