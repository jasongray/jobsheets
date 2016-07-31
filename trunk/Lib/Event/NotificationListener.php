<?php
/**
 *  Notify event handler
 *
 *  Used to register events for notifying the end user of notifications
 *
 *  Copyright (c) Webwidget Pty Ltd (http://whispli.com.au)
 *
 *  Licensed under The MIT license
 *  Redistributions of this file must retain the above copyright notice
 *
 *  @copyright      Copyright (c) Webwidget Pty Ltd (http://whispli.com.au)
 *  @package        JobSheets
 *  @author         Jason Gray
 *  @version        1.0
 *  @license        http://www.opensource.org/licenses/mit-license.php MIT License
 *
 */
App::uses('CakeEventListener', 'Event');
App::uses('HttpSocket', 'Network/Http');
App::uses('CakeEmail', 'Utility');

/**
 *   Notify event class
 *
 *   @package        JobSheets.Lib.Event
 */ 
class NotificationListener implements CakeEventListener {
	
	protected $host = 'http://localhost:3000/';

/**
 * Implemented events for the listener
 * 
 * Add events here that are triggered and the corresponding method
 *
 * @return array
 */
	public function implementedEvents ()
	{
		return array(
			'Model.Job.new' => array(
				'callable' => 'newJobNotification',
				'passParams' => true,
			),
			'Model.Job.updated' => array(
				'callable' => 'updatedJobNotification',
				'passParams' => true,
			),
		);
	}
	
	
/**
 * New job notifier
 *
 * Sends a notification to the allocated user a job has been created.
 * 
 * @param $event
 * @return void
 */
	public function newJobNotification ($data)
	{
		if (empty($this->data['Job']['user_id'])) {
			return false;
		}
		$user = $this->getUserDetail($this->data['Job']['user_id']);
		if (!$user) {
			return false;
		}
		if (isset($user['User']['settings']) && !empty($user['User']['settings']['Job'])) {
			$st = $user['User']['settings']['Job'];
			
		}
		
		return;
	}
	
	
/**
 * Updated job notifier
 *
 * Sends a notification to the allocated user when a job has been updated.
 * 
 * @param $event
 * @return void
 */
	public function updatedJobNotification ($data)
	{
		
		return;
	}

/**
 * Get user information
 *
 * @param $id the user id
 * @param $fields array of fields to return, defaults to all.
 * @return array
 */
	private function getUserDetail ($id = null, $fields = null)
	{
		$this->User = ClassRegistry::init('User');
		$this->User->id = $id;
		if (!$this->User->exists()) {
			return false;
		}
		$this->User->recursive = 0;
		return $this->User->read($fields);
	}
	
/** 
 * Send notification to node js
 *
 * @param $endpoint
 * @param $data
 * @param $auth
 * @return void
 */
	private function sendNotification ($endpoint, $data = array(), $auth = array())
	{
		if (!empty($data)) {
			$socket = new HttpSocket();
			if (!empty($auth)) {
				$endpoint = $endpoint . '?' . http_build_query($auth);
			}
			$resp = $socket->post($this->host . $endpoint, $data);
			CakeLog::write('debug', json_encode(array('url' => $this->host . $endpoint, 'data' => $data)));
			return $resp->code;
		}
		return false;
	}
 


}
