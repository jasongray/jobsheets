<?php
/**
 * General Ledger model.
 *
 * General Ledger model-related methods here.
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
 * Gl Model
 *
 */
class Gl extends AppModel {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'gl';

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
		'Account' => array(
			'className' => 'Account',
			'foreignKey' => 'account_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * Record a sale from invoice creation.
 *
 * @var array $client The client session information
 * @var array $data The invoice data
 * @return void
 */
	public function postSale($client = array(), $data = array()) {
		if (!empty($client) && !empty($data)) {
			
		}
	}


}
