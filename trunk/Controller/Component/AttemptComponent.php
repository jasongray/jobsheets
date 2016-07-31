<?php
/**
 *  Attempt component
 *
 *  Simple component which attempts to stop or inhibit brute force attacks by
 *  hasing together data sent to the component along with the client IP address
 *  and the requested url. 
 *
 *  Copyright (c) Fraudsec Pty Ltd (http://whispli.com.au)
 *
 *  Licensed under The MIT license
 *  Redistributions of this file must retain the above copyright notice
 *
 *  @copyright      Copyright (c) Fraudsec Pty Ltd (http://whispli.com.au)
 *  @package        Fraudsec
 *  @author         Jason Gray
 *  @version        1.0
 *  @license        http://www.opensource.org/licenses/mit-license.php MIT License
 *
 */
App::uses('Component', 'Controller');
App::uses('Security', 'Utility');

/**
 *   Attempt Component
 *
 *   @package        Fraudsec.Controller.Component
 */ 
class AttemptComponent extends Component {

/**
 * Attempt settings. These settings control the number of login attempts.
 *
 * - `limit` The maximum limit users can attempt to login. Defaults to 5
 * - `duration` The initial amount of time to lockout. Defaults to 10 minutes.
 *      - This value is parsed to PHPs built in strtotime.
 * - `type` The type of encryption to use to hash the string.
 *
 * @var array
 */
	public $settings = array(
		'limit' => 5,
		'duration' => '+10 minutes',
		'type' => 'basic',
	);

/**
 * Client IP address
 *
 * @var string
 */
	protected $ip = null;

/**
 * Encryption key
 * Generall should be 256 bits long
 *
 * @var string
 */
	protected $key = 'g^4dEwSD6H6uJn!1#56yHfg[)98&56t7846e5r';

/**
 * Controller reference
 *
 * @var Controller
 */
	protected $Controller = null;
	
/**
 * Constructor
 *
 * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
 * @param array $settings Array of configuration settings.
 */
    public function __construct(ComponentCollection $collection, $settings = array()) 
	{
		$settings = array_merge($this->settings, (array)$settings);
		$this->Controller = $collection->getController();
        parent::__construct($collection, $settings);
    }

/**
 * Initialise the component and settings
 *
 * @return void
 */
    public function startUp(Controller $controller) 
	{
		$this->Attempt = ClassRegistry::init('Attempt');
		$this->ip = $this->Controller->request->clientIp();
    } 
	
/**
 * Limit login attempt 
 * Send a string of data which is hashed with the controller/action and IP address to limit
 * the number of logins based on the component settings.
 *
 * ### Useage ###
 * $this->Attempt->limit($this->data['User']['username'])
 * where the string $this->data['User']['username'] forms part of the string to control the 
 * login attempts by. This variable can be anything.
 *
 * @param string The data to be hashed.
 * @return bool
 */
	public function limit($data = null) 
	{
		return $this->Attempt->limit($this->_encrypt($data), $this->settings['limit']);
	}

/**
 * Failed login attempt 
 *
 * @param string The data to be hashed.
 * @return bool
 */
	public function fail($data = null) 
	{
		return $this->Attempt->fail($this->ip, $this->Controller->request->url, $this->settings['duration'], $this->_encrypt($data));
	}

/**
 * Reset login attempts based on the action
 *
 * @param string The data to be hashed.
 * @return bool
 */
	public function reset($action = null) 
	{
		if ($action) {
			return $this->Attempt->reset($this->ip, $action);
		}
		return false;
	}

/**
 * Clean login attempts best before date
 *
 * @param string The data to be hashed.
 * @return bool
 */
	public function cleanup() 
	{
		return $this->Attempt->cleanup();
	}

/**
 * Encrypts $value using public $type method in Security class
 *
 * @param string $value Value to encrypt
 * @return string Encoded values
 */
	protected function _encrypt($value) {
		if (is_array($value)) {
			$value = json_encode($value);
		}
		// create any type of combination of the parameters you want... or remove any!?
		$value = $value . '-' . $this->Controller->request->url . '-' . $this->ip;
		if ($this->settings['type'] === 'rijndael') {
			$cipher = Security::rijndael($value, $this->key, 'encrypt');
		}
		if ($this->settings['type'] === 'cipher') {
			$cipher = Security::cipher($value, $this->key);
		}
		if ($this->settings['type'] === 'aes') {
			$cipher = Security::encrypt($value, $this->key);
		}
		if ($this->settings['type'] === 'basic') {
			$cipher = base64_encode($value);
		}
		return $cipher;
	}

}