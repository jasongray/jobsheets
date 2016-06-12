<?php
/**
 * Quote Item model.
 *
 * QuoteItem model-related methods here.
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
 * QuoteItem Model
 *
 * @property Quote $quote
 */
class QuoteItem extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Quote' => array(
			'className' => 'Quote',
			'foreignKey' => 'quote_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
	public function updateTotal($quote_id) {
		$this->virtualFields = array('item_totals' => 'SUM(amount)');
		$result = $this->find('first', array('fields' => array('item_totals'), 'conditions' => array('quote_id' => $quote_id), 'group' => 'quote_id'));
		if ($result) {
			$data['Quote']['subtotal'] = $result['QuoteItem']['item_totals'];
			$this->Quote->id = $quote_id;
			$this->Quote->recursive = -1;
			$q = $this->Quote->read(null, $this->Quote->id);
			// calculate tax on updated total..
			$data['Quote']['tax_amt'] = $q['Quote']['tax_rate'] * $data['Quote']['subtotal'];
			$data['Quote']['total'] = $data['Quote']['subtotal'] + $data['Quote']['tax_amt'];
			$this->Quote->save($data);
		}
	}

}
