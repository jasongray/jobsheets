<?php 
/**
 * SMS Component
 *
 * Send an sms using Esendex API
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
 * @package       JobSheet.Component
 * @since         JobSheets v 0.0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Component', 'Controller');

/**
 * SMS component
 *
 * @package JobSheets.Controller.Component
 */
class SMSComponent extends Component {

/**
 * authentication settings for the Esendex API
 *
 * @var array
 */
	public $settings = array(
		'Account' => '',
		'Login' => '',
		'Password' => '',
		'SendID' => ''
	);

/** 
 * protected variable
 *
 * @var void
 */
	protected $service;

/**
 * constructor
 *
 * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
 * @param array $settings Array of configuration settings for this component
 */
	public function __construct (ComponentCollection $collection, $settings = array()) {
		$settings = array_merge($this->settings, (array)$settings);
		parent::__construct($collection, $settings);
	}

/**
 * initialise the component and load the vendor class files
 *
 */
	public function init () {
		error_reporting(0);
		App::import('Vendor', 'Esendex', array('file' => 'sms/autoload.php'));
        $auth = new \Esendex\Authentication\LoginAuthentication($this->settings['Account'], $this->settings['Login'], $this->settings['Password']);
        $this->service = new \Esendex\DispatchService($auth);
	}

/**
 * Send an SMS
 *
 * @param $phone integar Hopefully a correct mobile phone number
 * @param $text string String of text to send as the message
 * @return bool
 */ 
	public function send ($phone = false, $text = null) {
		$_message = new \Esendex\Model\DispatchMessage($this->settings['SendID'], $phone, $text, \Esendex\Model\Message::SmsType);
		$result = $this->service->send($_message);
	}

}
