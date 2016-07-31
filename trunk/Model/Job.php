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
App::uses('CakeEvent', 'Event');

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
	
	public function afterSave($created, $options = array()) {
		if ($created) {
			$event = new CakeEvent('Model.Job.new', $this, array(
			    'data' => $this->data
			));
		} else {
			$event = new CakeEvent('Model.Job.updated', $this, array(
			    'data' => $this->data
			));
		}
		$this->getEventManager()->dispatch($event);
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
 * Jobs in nice pretty calendar format
 *
 * @param $start Start datetime string
 * @param $end End satetime string
 * @return array
 */
	public function calendardata($start = null, $end = null) {
		if (!$start) {
			$start = date('Y-m-d', strtotime('previous sunday'));
		}
		if (!$end) {
			$end = date('Y-m-d', strtotime('next saturday'));
		}
		return $this->find('all', array(
			'conditions' => array(
				'Job.allocated BETWEEN ? AND ?' => array($start, $end), 
				'Job.status' => 1,
				'Job.client_id' => CakeSession::read('Auth.User.client_id'),
				'Job.client_meta' => CakeSession::read('Auth.User.client_meta'),
			),
			'order' => array(
				'Job.allocated ASC'
			),
		));

	}

/**
 * Get the current jobs for the current user
 *
 * @return array
 */
	public function current() {
		$this->recursive = 0;
		return $this->find('all', array(
			'conditions' => array( 
				'Job.status <' => 9,
				'Job.client_id' => CakeSession::read('Auth.User.client_id'),
				'Job.client_meta' => CakeSession::read('Auth.User.client_meta'),
			),
			'order' => array(
				'Job.allocated ASC'
			),
			'limit' => 12
		));
	}

/**
 * Get the current unallocated jobs for the current user
 *
 * @return array
 */
	public function outstanding() {
		$this->recursive = 0;
		$this->virtualFields = array('cnt' => 'COUNT(DISTINCT(Job.id))');
		$data = $this->find('first', array(
			'fields' => array(
				'Job.cnt',
			),
			'conditions' => array( 
				'Job.status' => 0,
				'Job.client_id' => CakeSession::read('Auth.User.client_id'),
				'Job.client_meta' => CakeSession::read('Auth.User.client_meta'),
			),
		));
		if ($data) {
			return array('outstanding' => $data['Job']['cnt']);
		} else {
			return array('outstanding' => 0);
		}
	}

/**
 * Find jobs from the database
 *
 * @param string $type - the type of find, 'all', 'first', 'list' etc
 * @return array
 */
	public function findJobs($type = 'all') {
		$cond = $this->getJobs();
		return $this->find($type, $cond['paginate']);
	}

/**
 * Find job from the database
 *
 * @param string $id - the job id
 * @return array
 */
	public function findJob($id = false) {
		if (!$id) return;
		$cond = $this->getJobs(array('Job.id' => $id));
		$this->bindModel(array('hasMany' => array('JobItem')), false);
		return $this->find('first', $cond['paginate']);
	}

/**
 * Get jobs for the index view
 *
 * @param string $status
 * @param bool $role - Override role and return user jobs only
 * @return array
 */
	public function getJobs($conditions = array(), $limit = 25, $order = array(), $joins = false, $status = null, $role = false) {
		$this->recursive = 2;
		
		$this->unBindModel(array('hasMany' => array('JobItem')), false);
		$this->Client->unBindModel(array('hasMany' => array('User')), false);
		$this->Location->unBindModel(array('hasMany' => array('Job')), false);
		$this->User->unBindModel(array('belongsTo' => array('Role', 'Client')), false);
		
		$role = CakeSession::read('Auth.User.role_id');
		$template = CakeSession::read('Auth.Client.template');
		$client_id = CakeSession::read('Auth.User.client_id');
		$client_meta = CakeSession::read('Auth.User.client_meta');

		$JobStatus = array('Job.status <' => 8);
		$class_status = 'default';

		if (isset($status) && !empty($status)) {
			if ($status == 'completed') {
				$JobStatus = array('Job.status' => 8);
			}
			if ($status == 'cancelled') {
				$JobStatus = array('Job.status' => 9);
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
					'order' => array('Job.client_id ASC', 'Job.id DESC')
				);
				$template = 'admin_index';
				break;
			case 2:
			case 3:
				$paginate = array(
					'conditions' => array_merge(array(
						'Job.client_id' => $client_id,
						'Job.client_meta' => $client_meta,
						), $JobStatus, $conditions
					),
					'limit' => 25, 
					'order' => array('Job.created ASC, Job.status ASC'),
				);
				$template = 'index';
				break;
			case 4:
			default:
				$paginate = array(
					'conditions' => array_merge(array(
						'Job.user_id' => CakeSession::read('Auth.User.id'),
						'Job.client_id' => $client_id,
						'Job.client_meta' => $client_meta,
						), $JobStatus, $conditions
					),
					'limit' => 25, 
					'order' => array('Job.status ASC, Job.created ASC'),
				);
				$template = 'index_user';
				break;
		}
		return compact('paginate', 'template', 'class_status');

	}

}
