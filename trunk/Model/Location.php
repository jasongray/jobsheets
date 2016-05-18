<?php
/**
 * Location model.
 *
 * Location model-related methods here.
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
 * Location Model
 *
 */
class Location extends AppModel {
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
		'Postcode' => array(
			'className' => 'Postcode',
			'foreignKey' => 'postcode_id',
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
		'Job' => array(
			'className' => 'Job',
			'foreignKey' => 'location_id',
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


/**
 * Match location
 *
 * Search the post data to find a location, if not found, add the location to the database
 *
 * @param $post 
 * @return mixed Id on true, bool false on error
 */
	public function match($post = array()) {
		if (!empty($post) && isset($post['postcode_id']) && !empty($post['postcode_id'])) {
			$this->recursive = -1;
			$data = array();
			$data_array = $this->schema();
			foreach($post as $k => $v) {
				if (array_key_exists($k, $data_array)) {
					$data[$k] = $v;
				}
			}
			unset($data['id']);unset($data['created']);unset($data['modified']);
			$str = implode('-', array_filter($data));
			$find = 'CONCAT_WS("-", Location.property, Location.unit, Location.address_from, Location.address_to, Location.address_street)';
			$this->virtualFields = array('location' => $find);
			if ($_loc = $this->find('first', array('fields' => array('id'), 'conditions' => array("$find LIKE '$str'")))) {
				return $_loc['Location']['id'];
			} else {
				$this->save($data);
				return $this->id;
			}
		}
		return false;
	}
}
