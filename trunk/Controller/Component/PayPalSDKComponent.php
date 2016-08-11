<?php 
/**
 * PaypalSDK Component
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
 * PaypalSDK component
 *
 * @package JobSheets.Controller.Component
 */
class PayPalSDKComponent extends Component {

/**
 * API Credentials
 *
 * @var array
 */
	public $settings = array(
		'clientId' => 'AXj4wLlXiGEElnSoyBAZLfvFuxN6nH7Xz-r6JGKA8BOrTKpYjcoGeVHV58FeJlG-GCP-hE32gxIdVXlQ',
		'clientSecret' => 'EMhdj4fWXZzu1lb_x5TbQKaDif3TEm5xxCEPCMIWoPYzKKdwMBy8hZLMzdA_xlxGF-PelM68Ustrz-2S',
		'mode' => 'sandbox',
	);

/**
 * API Context Object
 *
 * @var array
 */
	protected $apiContext;

/**
 * Errors
 *
 * @var array
 */
	protected $_errors;

/**
 * constructor
 *
 * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
 * @param array $settings Array of configuration settings for this component
 * @return void
 */
	public function __construct (ComponentCollection $collection, $settings = array()) {
		$this->settings = array_merge($this->settings, (array)$settings);
		parent::__construct($collection, $this->settings);
		App::import('Vendor', 'PayPalSDK', array('file' => 'PayPal/bootstrap.php'));
		App::import('Helper', 'Html');
	}

/**
 * Creates API context for Paypal calls
 *
 * @return void
 */
	public function oauthPaypal() {
		$api = new \PayPal\Rest\ApiContext(
			new \PayPal\Auth\OAuthTokenCredential(
				$this->settings['clientId'],
				$this->settings['clientSecret']
			)
		);
		$api->setConfig(
	        array(
	            'mode' => $this->settings['mode'],
	            'log.LogEnabled' => true,
	            'log.FileName' => APP . 'tmp' . DS . 'logs' . DS . 'PayPalSDK.log',
	            'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
	            'cache.enabled' => true,
	            // 'http.CURLOPT_CONNECTTIMEOUT' => 30
	            // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
	            //'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
	        )
	    );
	    $this->apiContext = $api;
	}

/**
 * Create a billing plan
 *
 * @param array $plan The plan object
 * @return mixed
 */
	public function createPlan($planob = array()) {
		if (empty($planob)){
			return false;
		}
		if (empty($this->apiContext)) {
			$this->oauthPaypal();
		}

		// create new plan
		$plan = new \PayPal\Api\Plan();
		$plan->setName($planob['Plan']['name'])->setDescription($planob['Plan']['description'])->setType('FIXED');

		// set payment definition
		$paymentDefinition = new \PayPal\Api\PaymentDefinition();
		$paymentDefinition->setName(sprintf('%s Payments', $planob['Plan']['name']))
			->setType(strtoupper($planob['Plan']['type']))
			->setFrequency($planob['Plan']['frequency'])
			->setFrequencyInterval($planob['Plan']['intervals'])
			->setCycles($planob['Plan']['cycles'])
			->setAmount(new \PayPal\Api\Currency(array('value' => $planob['Plan']['amount'], 'currency' => 'AUD')));

		// set tax
		$chargeModel = new \PayPal\Api\ChargeModel();
		$chargeModel->setType('TAX')->setAmount(new \PayPal\Api\Currency(array('value' => round($planob['Plan']['amount'] * 0.1, 2), 'currency' => 'AUD')));
		$paymentDefinition->setChargeModels(array($chargeModel));

		$plan->setPaymentDefinitions(array($paymentDefinition));
		$plan->setMerchantPreferences($this->merchantPreferences());

		try {
			$output = $plan->create($this->apiContext);
		} catch (Exception $ex) {
			$this->_errors[] = $ex;
			return false;
		}
		return $output->getId();
	}

/**
 * Retreive a plan
 *
 * @param string $id The plan Id
 * @return mixed
 */
	public function getPlan($id = false) {
		if (empty($id)) {
			return false;
		}
		if (empty($this->apiContext)) {
			$this->oauthPaypal();
		}

		try {
			$plan = \PayPal\Api\Plan::get($id, $this->apiContext);
		} catch (Exception $ex) {
			$this->_errors[] = $ex;
			return false;
		}
		return $plan;
	}

/**
 * Activate/deactivate a plan
 *
 * @param string $id The plan Id
 * @param string $state defaults to ACTIVE, set to CREATED to deactivate the plan
 * @return bool
 */
	public function activatePlan($id = false, $state = 'ACTIVE') {
		if (empty($id)) {
			return false;
		}
		if (empty($this->apiContext)) {
			$this->oauthPaypal();
		}

		try {
			$patch = new \PayPal\Api\Patch();
			$value = new \PayPal\Common\PayPalModel('{"state":"'.$state.'"}');
			$patch->setOp('replace')->setPath('/')->setValue($value);
			$patchRequest = new \PayPal\Api\PatchRequest();
			$patchRequest->addPatch($patch);
			$plan = \PayPal\Api\Plan::get($id, $this->apiContext);
			$plan->update($patchRequest, $this->apiContext);
		} catch (Exception $ex) {
			$this->_errors[] = $ex;
			return false;
		}
		return true;
	}

/**
 * Delete a plan
 *
 * @param string $id The plan Id
 * @return bool
 */
	public function deletePlan($id = false) {
		if (empty($id)) {
			return false;
		}
		if (empty($this->apiContext)) {
			$this->oauthPaypal();
		}
		$out = false;
		$createdPlan = $this->getPlan($id);
		try {
			$out = $createdPlan->delete($this->apiContext);
		} catch (Exception $ex) {
			$this->_errors[] = $ex;
			return false;
		}
		return $out;
	}

/**
 * Create a billing agreement
 *
 * @param string $planId
 * @param string $payment_method
 * @param array $cc
 * @param array $client
 * @return mixed
 */
	public function createAgreement($planId = false, $payment_method = 'paypal', $cc = array(), $client = array()) {
		if (empty($planId)) {
			return false;
		}
		if (empty($this->apiContext)) {
			$this->oauthPaypal();
		}

		$agreement = new \PayPal\Api\Agreement();
		$agreement->setName(sprintf('PA::%s', $client['Client']['id']))
			->setDescription(sprintf('Payment Agreement with %s', $client['Client']['name']))
			->setStartDate(date('c'));

		$plan = new \PayPal\Api\Plan();
		$plan->setId($planId);
		$agreement->setPlan($plan);

		$payer = new \PayPal\Api\Payer();

		if ($payment_method == 'credit_card' && !empty($cc)) {
			$payer->setPaymentMethod($payment_method)
				->setPayerInfo(new \PayPal\Api\PayerInfo(array('email' => $client['Client']['email'])));
			$creditCard = new \PayPal\Api\CreditCard();
			$creditCard->setType($this->determineCardType($cc['number']))
				->setNumber($cc['number'])
				->setExpireMonth($cc['exmonth'])
				->setExpireYear($cc['exyear'])
				->setCvv2($cc['ccv']);

			$fundingInstrument = new \PayPal\Api\FundingInstrument();
			$fundingInstrument->setCreditCard($creditCard);
			$payer->setFundingInstruments(array($fundingInstrument));
		} else {
			$payer->setPaymentMethod('paypal');
		}

		$agreement->setPayer($payer);

		try {
			$agreement->create($this->apiContext);
		} catch (Exception $ex) {
			$this->_errors[] = $ex;
			return false;
		}
		return array('id' => $agreement->getId(), 'link' => $agreement->getApprovalLink());
	}

/**
 * Global merchant preferences
 *
 * @return object
 */
	public function merchantPreferences(){
		$merchantPreferences = new \PayPal\Api\MerchantPreferences();
		$merchantPreferences->setReturnUrl(Router::url(array('controller' => 'clients', 'action' => 'agreement'), true))
			->setCancelUrl(Router::url(array('controller' => 'clients', 'action' => 'account'), true))
			->setAutoBillAmount("yes")
			->setInitialFailAmountAction("CONTINUE")
			->setMaxFailAttempts("0")
			->setSetupFee(new \PayPal\Api\Currency(array('value' => 0, 'currency' => 'AUD')));
		return $merchantPreferences;
	}

/**
* Return errors
*
* @return array
*/
	public function getErrors() {
		return $this->_errors;
	}

/**
 * Determine the card type
 *
 * @param string $cardnumber
 * @return string $type
 */
	public function determineCardType($cardnumber) {
		if (preg_match('/^4[0-9]{0,15}$/', $cardnumber)){
			return 'visa';
		}
		if (preg_match('/^5$|^5[1-5][0-9]{0,14}$/', $cardnumber)){
			return 'mastercard';
		}
		if (preg_match('/^3$|^3[47][0-9]{0,13}$/', $cardnumber)){
			return 'amex';
		}
		if (preg_match('/^3$|^3[068]$|^3(?:0[0-5]|[68][0-9])[0-9]{0,11}$/', $cardnumber)){
			return 'diners';
		}
		if (preg_match('/^6$|^6[05]$|^601[1]?$|^65[0-9][0-9]?$|^6(?:011|5[0-9]{2})[0-9]{0,12}$/', $cardnumber)){
			return 'discover';
		}
		if (preg_match('/^2[1]?$|^21[3]?$|^1[8]?$|^18[0]?$|^(?:2131|1800)[0-9]{0,11}$|^3[5]?$|^35[0-9]{0,14}$/', $cardnumber)){
			return 'jcb';
		}
		return '';
	}

}