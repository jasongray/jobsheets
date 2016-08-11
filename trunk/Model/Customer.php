<?php
/**
 * Customer model.
 *
 * Customer model-related methods here.
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
 * Customer model for JobSheets.
 *
 * @package       JobSheets.Model
 */

class Customer extends AppModel {


/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CustomerNote' => array(
			'className' => 'CustomerNote',
			'foreignKey' => 'customer_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'CustomerNote.created DESC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function getCustomerString($str) {
		$array = array();
		$this->virtualFields = array('address' => 'IFNULL(billing_address, CONCAT(
			COALESCE(unit, ""), IF(LENGTH(unit), "/", ""), 
			COALESCE(address_from, ""), IF(LENGTH(address_to), " - ", ""), COALESCE(address_to, ""), IF(LENGTH(address_from), " ", ""), 
			COALESCE(address_street, ""), IF(LENGTH(address_street), "\r\n", ""), 
			COALESCE(suburb, ""), IF(LENGTH(suburb), " ", "")
			))');
		$this->recursive = -1;
		$result = $this->find('all', array(
			'fields' => array(
				'id', 'name', 'address', 'phone', 'email', 'contact'
			),
			'conditions' => array(
				'OR' => array(
					'name LIKE ?' => $str.'%',
				),
				'Customer.client_id' => CakeSession::read('Auth.User.client_id'),
				'Customer.client_meta' => CakeSession::read('Auth.User.client_meta'),
			),
		));
		if ($result) {
			for($i=0; $i<count($result); $i++) {
				$l = $result[$i];
				$array[] = array('id' => $l['Customer']['id'], 'text' => $l['Customer']['name'], 'params' => array('address' => $l['Customer']['address'], 'phone' => $l['Customer']['phone'], 'email' => $l['Customer']['email'], 'contact' => $l['Customer']['contact']));
			}
		}
		return $array;
	}

	public function getLocation($id = false) {
		if ($id) {
			$this->virtualFields = array('contact_name' => 'Customer.contact', 'contact_phone' => 'Customer.phone', 'contact_email' => 'Customer.email');
			$this->recursive = -1;
			$result = $this->find('first', array(
				'fields' => array(
					'property', 'unit', 'address_from', 'address_to', 'address_street', 'suburb', 'postcode_id',
					'contact_name', 'contact_phone', 'contact_email',
				),
				'conditions' => array(
					'Customer.id' => $id,
					'Customer.client_id' => CakeSession::read('Auth.User.client_id'),
					'Customer.client_meta' => CakeSession::read('Auth.User.client_meta'),
				),
			));
			if ($result) {
				return $result['Customer'];
			}
		}
		return false;
	}


	public function beforeSave($options = array()) {
		if (empty($this->data['Customer']['client_id'])) {
			$this->data['Customer']['client_id'] = CakeSession::read('Auth.User.client_id');
		}
		if (empty($this->data['Customer']['client_meta'])) {
			$this->data['Customer']['client_meta'] = CakeSession::read('Auth.User.client_meta');
		}
	    return true;

	}

/**
 * Add a note to the customer log
 *
 * @param array $data
 * @return array 
 */
	public function addNote($data = array()) {
		if (empty($data)) {
			return array('code' => '404', 'message' => __('Error no note to add'));
		}
		if (!isset($data['CustomerNote']['customer_id']) && empty($data['CustomerNote']['customer_id'])) {
			return array('code' => '400', 'message' => __('Error no customer_id'));
		}
		$this->CustomerNote->create();
		if ($this->CustomerNote->save($data)) {
			return array('code' => '200', 'message' => __('Customer note saved'));	
		}
		return array('code' => '400', 'message' => __('Error note not saved'));
	}

/**
 * Find customers from the database
 *
 * @param string $type - the type of find, 'all', 'first', 'list' etc
 * @return array
 */
	public function findCustomers($type = 'all') {
		$cond = $this->getConditions();
		return $this->find($type, $cond['paginate']);
	}

/**
 * Find job from the database
 *
 * @param string $id - the job id
 * @return array
 */
	public function findCustomer($id = false) {
		if (!$id) return;
		$cond = $this->getConditions(array('Customer.id' => $id));
		return $this->find('first', $cond['paginate']);
	}

/**
 * Get customer for specified user conditions.
 *
 * @param array $conditions
 * @return array
 */
	public function getConditions($conditions = array(), $limit = 25, $order = array(), $joins = false){
		$this->recursive = 1;
		$client = CakeSession::read('Auth.User.client_id');
		$meta = CakeSession::read('Auth.User.client_meta');
		$role = CakeSession::read('Auth.User.role_id');
		switch ($role) {
			case 1:
				$this->bindModel(array(
					'belongsTo' => array(
						'Client' => array(
							'className' => 'Client',
							'foreignKey' => 'client_id',
						),
					),
				));
				$order = array_merge($order,
					array(
						'Customer.client_id ASC',
						'Customer.id DESC'
					)
				);
				$template = 'admin_index';
				break;
			case 2:
			case 3:
				$conditions = array_merge($conditions, 
					array(
						'Customer.client_id' => $client,
						'Customer.client_meta' => $meta,
					)
				);
				$order = array_merge($order, 
					array(
						'Customer.name' => 'ASC',
					)
				);
				$template = 'index';
				break;
			case 4:
			default:
				$conditions = array_merge($conditions,
					array(
						'Customer.client_id' => $client,
						'Customer.client_meta' => $meta,
					)
				);
				$order = array_merge($order, 
					array(
						'Customer.name' => 'ASC', 
						'Customer.created' =>  'ASC'
					)
				);
				$template = 'index_user';
				break;
		}
		return array('paginate' => array('conditions' => $conditions, 'limit' => $limit, 'order' => $order), 'template' => $template);
	}
	
}
