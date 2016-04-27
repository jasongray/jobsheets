<?php
/**
 * Postcode model.
 *
 * Postcode model-related methods here.
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
 * Postcode model for JobSheets.
 *
 * @package       JobSheets.Model
 */

class Postcode extends AppModel {

	public function getSuburbString($str) {
		$array = array();
		$this->virtualFields = array('locality' => 'CONCAT(suburb, ", ", state, " ", code)');
		$result = $this->find('all', array(
			'fields' => array(
				'id', 'locality'
			),
			'conditions' => array(
				'OR' => array(
					'suburb LIKE ?' => $str.'%',
					'code LIKE ?' => $str.'%',
				)
			),
		));
		if ($result) {
			for($i=0; $i<count($result); $i++) {
				$l = $result[$i];
				$array[] = array('id' => $l['Postcode']['id'], 'suburb' => $l['Postcode']['locality']);
			}
		}
		return $array;
	}
	
}
