<?php
/**
 *	Captcha helper
 *
 *	Creates a simple captcha image
 *
 *	Copyright (c) Webwidget Pty Ltd (http://webwidget.com.au)
 *
 *	Licensed under The MIT license
 *	Redistributions of this file must retain the above copyright notice
 *
 *	@copyright  	Copyright (c) Webwidget Pty Ltd (http://webwidget.com.au)
 *	@package		WebCart
 *	@author			Jason Gray
 *	@version		1.8
 *	@license 		http://www.opensource.org/licenses/mit-license.php MIT License
 *
 */

App::uses('AppHelper', 'View/Helper');

/**
*	CaptchaHelper class for creation of captcha image
*
*	@package WebCart.Cake.View.Helper
*
*/
class CaptchaHelper extends AppHelper  {

/**
* Reference to settings
*
* @var array
*/
	public $settings = array(
		'width' => 110,
		'height' => 55,
		'length' => 4,
		'bgcolour' => array(254,254,254),
		'txtcolour' => array(0,30,102),
		'noise' => array(41,115,207),
		'font' => 'sears',
		'fontsize' => 23,
		'fontlocation' => 'fonts',
		'quality' => 95,
	);

/**
* String of characters
*
* @var array
*/
	protected $chars = '0123456789+abcdefghijklmnopqrstuvwxyz!?@ABCDEFGHIJKLMNOPQRSTUVWXYZ';

/**
 * Reference to the image object
 *
 * @var obj
 */ 
	protected $img;

/**
 * Reference to the font
 *
 * @var obj
 */ 
	protected $font;

/**
* CakePHP helpers to load
*
* @var array
*/
	public $helpers = array('Html', 'Session');

/**
* Constructor
*
* @param View $view The View this helper is being attached to.
* @param array $settings Configuration settings for the helper.
*
*/
	public function __construct(View $View, $settings = array()) {
		if (!extension_loaded('gd')) {
			throw new Exception ('GD image library is not loaded on your server. Check with your host to have it loaded before using this class.');	
		}
		$this->settings = array_merge($this->settings, $settings);
		$this->font = $this->loadFontFile($this->settings['font']);
		parent::__construct($View, $this->settings);
	}

/** 
 * Destructor method
 * Destroys any instance of the image
 *
 * @return void
 */
	public function __destruct () {
		if( $this->img !== null && get_resource_type($this->img) === 'gd' ) {
			imagedestroy($this->img);
		}
	}

/**
 * Generate a captcha type image and render to the view
 *
 * @param bool $return On true return the fully rendered image tag, on false return the base64 encoded image string.
 * @return mixed
 */
	public function image($return = true) {
		$_code = $this->generateString();
		CakeSession::write('Reset.captcha_code', $_code);

		$width = $this->settings['width'];
        $height = $this->settings['height'];

		$this->img = imagecreate($width, $height);
		$bgcolour = imagecolorallocate($this->img, $this->settings['bgcolour'][0], $this->settings['bgcolour'][1], $this->settings['bgcolour'][2]);
        $txtcolour = imagecolorallocate($this->img, $this->settings['txtcolour'][0], $this->settings['txtcolour'][1], $this->settings['txtcolour'][2]);
        $noise = imagecolorallocate($this->img, $this->settings['noise'][0], $this->settings['noise'][1], $this->settings['noise'][2]);
        
        // random dots
		for($i = 0; $i < ($width * $height) / 3; $i++) {
            imagefilledellipse($this->img, mt_rand(0, $width), mt_rand(0, $height), 1, 1, $noise);
        }
        // random lines
        for($i = 0; $i < ($width * $height) / 150; $i++) {
            imageline($this->img, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $noise);
        }
        // text
        $textbox = imagettfbbox($this->settings['fontsize'], rand(-17, 19), $this->font, $_code);
        $x = ($width - $textbox[4])/2;
        $y = ($height - $textbox[5])/2;
       // $y -= 5;
        imagettftext($this->img, $this->settings['fontsize'], rand(-17, 19), $x, $y, $txtcolour, $this->font, $_code);

        ob_start();
        imagepng($this->img, null, round(9 * $this->settings['quality'] / 100));
        $image_data = ob_get_contents();
        ob_end_clean();

        if ($return) {	
        	return $this->Html->image('data:image/png;base64,'.base64_encode($image_data), array('escape' => false));
        } else {
        	return 'data:image/png;base64,'.base64_encode($image_data);
        }
	}

/**
 * Generate a random string of characters
 *
 * @param int $length of the string to generate.
 * @return string
 */
	protected function generateString() {
		$str = '';
		for ($i = 0; $i < $this->settings['length']; $i++) {
			$str .= $this->chars[mt_rand(0, strlen($this->chars)-1)];
		}
		return $str;
	}


/**
 * Returns a font file location
 *
 * @param string $font The font name
 * @return string
 */
	protected function loadFontFile ($font){
		if (file_exists(WWW_ROOT . DS . $this->settings['fontlocation'] . DS . strtolower($font) . '.ttf')) {
			return $this->settings['fontlocation'] . '/' . strtolower($font) . '.ttf';
		} else {
			throw new Exception(sprintf('Unable to load font file %s. Please check you have uploaded the correct file to the "%s" directory!', $font, WWW_ROOT . DS . $this->settings['fontlocation'] . DS));
		}
	}

}
	