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
	    return true;

	}


/**
 * Generate a unique ID based on octal timestamp
 */
	private function generateID ($timestamp = false, $pad = 2, $base64 = false) {
		$code = false;
		if ($timestamp) {
			$hextime[] = $this->padstr(date('Y', $timestamp), 4);
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

}
