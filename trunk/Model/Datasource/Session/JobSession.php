<?php
/**
 * Database Session save handler. Allows saving session information into a model.
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
 * @package       JobSheet.Model.Datasource
 * @since         JobSheets v 0.0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('DatabaseSession', 'Model/Datasource/Session');
App::uses('ClassRegistry', 'Utility');

/**
 * JobSession extends DatabaseSession methods to be used with CakeSession.
 *
 * @package       Cake.Model.Datasource.Session
 */
class JobSession extends DatabaseSession {

/**
 * Reference to the cache key
 *
 * @var Model
 */
	public $key;

/**
 * Reference to the model handling the session data
 *
 * @var Model
 */
	protected $_model;

/**
 * Number of seconds to mark the session as expired
 *
 * @var int
 */
	protected $_timeout;

/**
 * Constructor. Looks at Session configuration information and
 * sets up the session model.
 */
	public function __construct() {
        $this->key = Configure::read('Session.handler.cache');
		$modelName = Configure::read('Session.handler.model');

		if (empty($modelName)) {
			$settings = array(
				'class' => 'Session',
				'alias' => 'Session',
				'table' => 'cake_sessions',
			);
		} else {
			$settings = array(
				'class' => $modelName,
				'alias' => 'Session',
			);
		}
		$this->_model = ClassRegistry::init($settings);
		$this->_timeout = Configure::read('Session.timeout') * 60;
    }

/**
 * Method called on open of a database session.
 *
 * @return bool Success
 */
	public function open() {
		return true;
	}

/**
 * Method called on close of a database session.
 *
 * @return bool Success
 */
	public function close() {
		return true;
	}

/**
 * Method used to read from a database session.
 *
 * @param int|string $id The key of the value to read
 * @return mixed The value of the key or false if it does not exist
 */
 	public function read($id) {
        $result = Cache::read($id, $this->key);
        if ($result) {
            return $result;
        }
        $row = $this->_model->find('first', array(
			'conditions' => array($this->_model->alias . '.' . $this->_model->primaryKey => $id)
		));

		if (empty($row[$this->_model->alias])) {
			return '';
		}

		if (!is_numeric($row[$this->_model->alias]['data']) && empty($row[$this->_model->alias]['data'])) {
			return '';
		}

		return (string)$row[$this->_model->alias]['data'];
    }   

/**
 * Helper function called on write for database sessions.
 *
 * Will retry, once, if the save triggers a PDOException which
 * can happen if a race condition is encountered
 *
 * @param int $id ID that uniquely identifies session in database
 * @param mixed $data The value of the data to be saved.
 * @return bool True for successful write, false otherwise.
 */
	public function write($id, $data) {
		if (!$id) {
			return false;
		}
		$result = Hash::get($_SESSION, 'Auth.User');
		$user_id = null;
		$client_id = null;
		$client_meta = null;
		if (is_array($result)) {
			$user_id = $result['id'];
			$client_id = $result['client_id'];
			$client_meta = $result['client_meta'];
		}
		$expires = time() + $this->_timeout;
		$record = compact('id', 'data', 'expires', 'user_id', 'client_id', 'client_meta');
		$record[$this->_model->primaryKey] = $id;

		$options = array(
			'validate' => false,
			'callbacks' => false,
			'counterCache' => false
		);
		Cache::write($id, $data, $this->key);
		try {
			return (bool)$this->_model->save($record, $options);
		} catch (PDOException $e) {
			return (bool)$this->_model->save($record, $options);
		}
	}   

/**
 * Method called on the destruction of a database session.
 *
 * @param int $id ID that uniquely identifies session in database
 * @return bool True for successful delete, false otherwise.
 */
    public function destroy($id) {
        Cache::delete($id, $this->key);
        return (bool)$this->_model->delete($id);
    }

/**
 * Helper function called on gc for database sessions.
 *
 * @param int $expires Timestamp (defaults to current time)
 * @return bool Success
 */
    public function gc($expires = null) {
        Cache::gc($this->key);
        if (!$expires) {
			$expires = time();
		} else {
			$expires = time() - $expires;
		}
		$this->_model->deleteAll(array($this->_model->alias . ".expires <" => $expires), false, false);
		return true;
    }

}