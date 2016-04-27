<?php
/**
 * Postcodes controller.
 *
 * Obtain Postcodes from the database
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
 * @package       JobSheet.Controller
 * @since         JobSheets v 0.0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');
/**
 * Postcodes Controller
 *
 * @property Role $Role
 */
class PostcodesController extends AppController {
	
	public function beforeFilter() {
	    parent::beforeFilter(); 
	}

/**
 * get method
 *
 * @return void
 */
	public function get() {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			$result = $this->Postcode->getSuburbString($this->request->data['search']);
			if ($result) {
				return json_encode($result);
			}
		}
		return null;
	}

}
