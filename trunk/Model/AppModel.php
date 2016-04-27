<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');
App::uses('CakeSession', 'Model/Datasource');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
	}

/**
 * Returns true if a record with particular ID exists.
 *
 * Overwriting default method in cake so we can add additional filters for client_meta
 *
 * If $id is not passed it calls `Model::getID()` to obtain the current record ID,
 * and then performs a `Model::find('count')` on the currently configured datasource
 * to ascertain the existence of the record in persistent storage.
 *
 * @param int|string $id ID of record to check for existence
 * @return bool True if such a record exists
 */
	public function isMine($id = null, $client_meta = null) {
		/*
		if ($id === false) {
			return false;
		}

		if ($client_meta === false) {
			return false;
		}

		if ($this->useTable === false) {
			return false;
		}

		return (bool)$this->find('count', array(
			'conditions' => array(
				$this->alias . '.' . $this->primaryKey => $id,
				$this->alias . '.' . 'client_meta' => $client_meta;
			),
			'recursive' => -1,
			'callbacks' => false
		));
		*/
		return true;
	}

/**
 * Returns last query executed.
 *
 * @return string
 */
	public function getLastQuery() {
		$dbo = $this->getDatasource();
		$logs = $dbo->getLog();
		$lastLog = end($logs['log']);
		return $lastLog['query'];
	}

}
?>