<?php
/**
 * Plans model.
 *
 * Plans for clients model-related methods here.
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
 * Plan Model
 *
 */
class Plan extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = '';

/**
 * Find the current plans on offer
 *
 * @param integer $plan_id The current plan id in the event that plan is retired
 * @return array
 */
	public function findPlans($plan_id = array()){
		$this->recursive = -1;
		$extra = array();
		if (!empty($plan_id)) {
			$extra = array('Plan.id IN' => $plan_id);
		}
		return $this->find('all', array(
			'conditions' => array_merge(array(
				'Plan.active' => 1,
				),
				$extra
			),
			'order' => array(
				'Plan.d_order ASC'
			),
		));
	}

}
