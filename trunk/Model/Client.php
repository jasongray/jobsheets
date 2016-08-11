<?php
/**
 * Client model.
 *
 * Client model-related methods here.
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
 * Client Model
 *
 */
class Client extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Plan' => array(
			'className' => 'plan',
			'foreignKey' => 'plan_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'id',
			'dependent' => false,
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

	public function subscribe_validate() {
		$this->validate = array(
			'number' => array(
				'rule' => array('cc', 'all', true, null),
				'message' => __('Please enter a valid credit card number'),
			),
			'ccv' => array(
				'ccvrule1' => array(
					'rule' => 'numeric',
					'message' => __('Please enter a valid security code'),
				),
				'ccvrule2' => array(
					'rule' => array('lengthBetween', 3, 4),
					'message' => __('Please enter a valid security code'),	
				),
			),
			'exmonth' => array(
				'rule' => array('checkExpiry', 'exyear'),
				'message' => __('Please enter a valid expiry date'),
			),
		);
	}

/**
 * Checks the expiry date of CC entered
 *
 * @param string $check
 * @param string $other
 * @return bool
 */
	public function checkExpiry($check, $other) {
		$date = $this->data[$this->name][$other].$check['exmonth'];
		$now = date('Ym');
		if (Validation::comparison($now, '>', $date)) {
			return false;
		}
		return true;
	}

/**
 * Before save method
 * Called before the data is saved to the database
 *
 * @param array $options
 * @return bool
 */
	public function beforeSave($options = array()) {
		if (!isset($this->data['Client']['client_meta']) && !empty($this->data['Client']['name'])) {
			$this->data['Client']['client_meta'] = base64_encode(time().$this->data['Client']['name']);
		}
	    return true;

	}

/**
 * Find clients from the database
 *
 * @param string $type - the type of find, 'all', 'first', 'list' etc
 * @return array
 */
	public function findClients($type = 'all') {
		$cond = $this->getConditions();
		return $this->find($type, $cond['paginate']);
	}

/**
 * Find job from the database
 *
 * @param string $id - the job id
 * @return array
 */
	public function findClient($id = false) {
		if (!$id) return;
		$cond = $this->getConditions(array('Client.id' => $id));
		return $this->find('first', $cond['paginate']);
	}

/**
 * Get client for specified user conditions.
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
				$order = array_merge($order,
					array(
						'Client.created ASC',
						'Client.id DESC'
					)
				);
				$template = 'admin_index';
				break;
			case 2:
			case 3:
				$conditions = array_merge($conditions, 
					array(
						'Client.id' => $client,
						'Client.client_meta' => $meta,
					)
				);
				$order = array_merge($order, 
					array(
						'Client.name' => 'ASC',
					)
				);
				$template = 'index';
				break;
			case 4:
			default:
				$conditions = array_merge($conditions,
					array(
						'Client.id' => $client,
						'Client.client_meta' => $meta,
					)
				);
				$order = array_merge($order, 
					array(
						'Client.name' => 'ASC', 
						'Client.created' =>  'ASC'
					)
				);
				$template = 'index_user';
				break;
		}
		return array('paginate' => array('conditions' => $conditions, 'limit' => $limit, 'order' => $order), 'template' => $template);
	}

}
