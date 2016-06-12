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

	public function getCustomerString($str) {
		$array = array();
		$this->virtualFields = array('address' => 'IFNULL(billing_address, CONCAT(
			COALESCE(unit, ""), IF(LENGTH(unit), "/", ""), 
			COALESCE(address_from, ""), IF(LENGTH(address_to), " - ", ""), COALESCE(address_to, ""), IF(LENGTH(address_from), " ", ""), 
			COALESCE(address_street, ""), IF(LENGTH(address_street), "\r\n", ""), 
			COALESCE(suburb, ""), IF(LENGTH(suburb), " ", "")
			))');
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
	
}
