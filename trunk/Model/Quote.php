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
 * @return void
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
 * Get the outstanding quotes for the current user
 *
 * @return array
 */
	public function outstanding() {
		$this->recursive = 0;
		$this->virtualFields = array('cnt' => 'COUNT(DISTINCT(Quote.id))');
		$data = $this->find('first', array(
			'fields' => array(
				'Quote.cnt',
			),
			'conditions' => array( 
				'Quote.status <' => 9,
				'Quote.client_id' => CakeSession::read('Auth.User.client_id'),
				'Quote.client_meta' => CakeSession::read('Auth.User.client_meta'),
			),
		));
		if ($data) {
			return array('count' => $data['Quote']['cnt']);
		} else {
			return array('count' => 0);
		}
	}


/**
 * Find jobs from the database
 *
 * @param string $type - the type of find, 'all', 'first', 'list' etc
 * @return array
 */
	public function findQuotes($type = 'all') {
		$cond = $this->getQuotes();
		return $this->find($type, $cond['paginate']);
	}

/**
 * Find job from the database
 *
 * @param string $id - the job id
 * @return array
 */
	public function findQuote($id = false) {
		if (!$id) return;
		$cond = $this->getQuotes(array('Quote.id' => $id));
		$this->bindModel(array('hasMany' => array('QuoteItem')), false);
		return $this->find('first', $cond['paginate']);
	}
	
/**
 * Find jobs from the database
 *
 * @param string $type - the type of find, 'all', 'first', 'list' etc
 * @return array
 */
	public function findByCustomer($conditions = array()) {
		$cond = $this->getQuotes($conditions);
		$this->recursive = -1;
		return $this->find('all', $cond['paginate']);
	}

/**
 * Get jobs for the index view
 *
 * @param string $status
 * @param bool $role - Override role and return user jobs only
 * @return array
 */
	public function getQuotes($conditions = array(), $limit = 25, $order = array(), $joins = false, $status = null) {
		$this->recursive = 2;

		$this->unBindModel(array('hasMany' => array('QuoteItem')), false);
		$this->Client->unBindModel(array('hasMany' => array('User')), false);
		$this->User->unBindModel(array('belongsTo' => array('Role', 'Client')), false);
		
		$role = CakeSession::read('Auth.User.role_id');
		$template = CakeSession::read('Auth.Client.template');
		$client_id = CakeSession::read('Auth.User.client_id');
		$client_meta = CakeSession::read('Auth.User.client_meta');

		$QuoteStatus = array('Quote.status <' => 8);
		$class_status = 'default';

		if (isset($status) && !empty($status)) {
			if ($status == 'completed') {
				$QuoteStatus = array('Quote.status' => 8);
			}
			if ($status == 'cancelled') {
				$QuoteStatus = array('Quote.status' => 9);
			}
			$class_status = $status;
		} 

		switch ($role) {
			case 1:
				$paginate = array(
					'conditions' => 
						$conditions
					, 
					'limit' => 25, 
					'order' => array('Quote.client_id ASC', 'Quote.id DESC')
				);
				$template = 'admin_index';
				break;
			case 2:
			case 3:
				$paginate = array(
					'conditions' => array_merge(array(
						'Quote.client_id' => $client_id,
						'Quote.client_meta' => $client_meta,
						), $QuoteStatus, $conditions
					),
					'limit' => 25, 
					'order' => array('Quote.created ASC, Quote.status ASC'),
				);
				$template = 'index';
				break;
			case 4:
			default:
				$paginate = array(
					'conditions' => array_merge(array(
						'Quote.user_id' => CakeSession::read('Auth.User.id'),
						'Quote.client_id' => $client_id,
						'Quote.client_meta' => $client_meta,
						), $JobStatus, $conditions
					),
					'limit' => 25, 
					'order' => array('Quote.status ASC, Quote.created ASC'),
				);
				$template = 'index_user';
				break;
		}
		return compact('paginate', 'template', 'class_status');

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
 * @param $check Integar 
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
 * @param $check Integar 
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
 * @param $data Array 
 * @return void
 */
	public function updateTax($id = false, $data = array()) {
		if (!empty($data) && !empty($data['Quote']['tax_id'])) {
			App::uses('Tax', 'Model');
			$this->Tax = new Tax();
			$t = $this->Tax->read(null, $data['Quote']['tax_id']);
			if (!empty($t)) {
				$this->id = $id;
				$this->saveField('tax_rate', $t['Tax']['rate']);
				$this->saveField('tax_name', $t['Tax']['name']);
			}

		}
	}

/**
 * Convert a quote to an invoice
 *
 * @param $id integer The quote ID
 * @return bool
 */
	public function convertToJob($quote_id = null) {
		if ($quote_id) {
			$this->id = $quote_id;
			if ($this->exists()) {
				// read quote information
				$this->recursive = -1;
				$q = $this->read(null, $this->id);
				unset($q['Quote']['id']); 
				unset($q['Quote']['created']); 
				unset($q['Quote']['modified']); 
				$data['Job'] = array_merge(
					$q['Quote'],
					array('reference' => __('From quote #'.$this->id))
				);
				App::uses('Job', 'Model');
				$this->Job = new Job();
				$this->Job->create();
				if ($this->Job->save($data)) {
					// read quote items to place them into the job items
					$qi = $this->QuoteItem->find('all', array('conditions' => array('quote_id' => $this->id)));
					$ji = array();
					if ($qi) {
						foreach ($qi as $_qi) {
							$ji[] = array('job_id' => $this->Job->id, 'description' => $_qi['QuoteItem']['description'], 'amount' => $_qi['QuoteItem']['amount'], 'status' => 1);
						}
						if (!empty($ji)) {
							$this->Job->JobItem->saveAll($ji);
						}
					}
					return $this->Job->id;
				}
			}
		}
		return false;
	}

}
