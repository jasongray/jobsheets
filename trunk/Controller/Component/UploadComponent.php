<?php
/**
 *  Upload component
 *
 *  Custom uploader to save files to the app.
 *
 * JobSheets : A tradies best friend (http://jobsheets.com.au)
 * Copyright (c) Webwidget Pty Ltd. (http://webwidget.com.au)
 *
 *  Licensed under The MIT license
 *  Redistributions of this file must retain the above copyright notice
 *
 *  @copyright      Copyright (c) Webwidget Pty Ltd (http://webwidget.com.au)
 *  @package        JobSheets
 *  @author         Jason Gray
 *  @version        1.0
 *  @license        http://www.opensource.org/licenses/mit-license.php MIT License
 *
 */
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 *   Upload Component
 *
 *   @package        JobSheets.Controller.Component
 */ 
class UploadComponent extends Component {

/**
 * Attempt settings. These settings control the number of login attempts.
 *
 * - `maxFileSize` the max file size in bytes. False ignore maxFileSize and uses php.ini limit.
 * - `uploadDir` the directory name in the webroot that you want the uploaded files saved to.
 * - 'useWWWROOT` set true to use Cake inbuilt WWW_ROOT constant otherwise set your own here.
 * - `allowedTypes` the allowed types of files that will be saved to the filesystem.
 * - `
 *
 * @var array
 */
	public $settings = array(
		'maxFileSize' => false,
		'uploadDir' => 'files',
		'useWWWROOT' => true,
		'allowedTypes' => array(
			'jpg' => array('image/jpeg', 'image/pjpeg'),
			'jpeg' => array('image/jpeg', 'image/pjpeg'), 
			'gif' => array('image/gif'),
			'png' => array('image/png','image/x-png'),
		),
		'unique' => true,
	);
	
/**
 * The file
 *
 * @var public
 */
	public $file = array();

/**
 * Array containing errors
 *
 * @var public
 */
	public $errors = array();	

/**
 * Constructor
 *
 * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
 * @param array $settings Array of configuration settings.
 */
    public function __construct(ComponentCollection $collection, $settings = array()) {
		$this->settings = array_merge($this->settings, (array)$settings);
		$this->Controller = $collection->getController();
		// check upload directory exists, if not create it
		$this->checkUploadDir();
        parent::__construct($collection, $this->settings);
    }

/**
 * Process a file for upload
 *
 * @param $file The file to upload
 * @return bool
 */
	public function process($file = false, $return = false) {
		$this->setFile($file);
		if(!$this->checkFile() || !$this->checkType() || !$this->checkSize()){
			return false;
		}
		if ($return) {
			$_file = file_get_contents($this->file['tmp_name']);
			return "data:" . $this->file['type'] . ";base64," . base64_encode($_file);
		}
		
		if ($this->settings['unique']) {
			$_file = md5($this->file['name']) . $this->_ext();
			// add in additional folder weirdness to reduce file clashes
			$_folder = substr($_file, 0, 2) . DS . substr($_file, 12, 2);
			$_file = time().$_file;
			$this->settings['uploadDir'] .= DS . $_folder;
		} else {
			$_file = $this->file['name'];
			$_folder = '';
		}
		if (!$this->checkUploadDir()) {
			return false;
		}
		
		if (move_uploaded_file($this->file['tmp_name'], $this->settings['uploadDir'] . $_file)){
			return $_folder . DS . basename($_file);
		} else {
			$this->_error(__('Unable to save file to file system.', true));
			return false;
		}
	}

/**
 * Set some settings
 *
 * @param $key
 * @param $value
 * @return void
 */
	public function set($key, $value) {
		$this->settings[$key] = $value;
	}

/**
 * Get some settings
 *
 * @param $key
 * @return array|string
 */
	public function get($key) {
		return $this->settings[$key];
	}

/**
 * Set the file to the class object
 *
 * @param $file the file
 * @return void
 */
	public function setFile($file = false) {
		if ($file) $this->file = $file;
	}

/**
 * Check the file size exceeds the max file size setting
 * 
 * @param $file The file name to be checked
 * @return bool
 */
	public function checkSize($file = null) {
		$this->setFile($file);
		if ($this->fileUploaded() && $this->file) {
			if(!$this->settings['maxFileSize']){ //We don't want to test maxFileSize
				return true;
			} else if($this->settings['maxFileSize'] && $this->file['size'] < $this->settings['maxFileSize']){
				return true;
			} else {
				$this->_error(sprintf(__('File exceeds %s limit.'), CakeNumber::toReadableSize($this->settings['maxFileSize'])));
			}
		}
		return false;
	}


/**
 * Check the file type is allowed by the settings
 * 
 * @param $file The file name to be checked
 * @return bool
 */
	public function checkType($file = null) {
		$this->setFile($file);
		foreach($this->settings['allowedTypes'] as $ext => $types){   
			if(!is_string($ext)){
				$ext = $types;
			}
	        if($ext == '*'){
				return true;
			}
			$ext = strtolower('.' . str_replace('.','', $ext));
			$file_ext = strtolower($this->_ext());
			if($file_ext == $ext){
				if(is_array($types) && !in_array($this->file['type'], $types)){
					$this->_error(sprintf(__('%s is not an allowed file type.',true),$this->file['type']));
					return false;
				} else {
					return true;
				}
			}
		}
		$this->_error(__('This file extension is not allowed.',true));
		return false;
	}

/**
 * Check if there is a file and uploaded
 * 
 * @param $file The file name to be checked
 * @return bool
 */
	public function checkFile($file = null) {
		$this->setFile($file);
		if ($this->fileUploaded() && $this->file) {
			if(isset($this->file['error']) && $this->file['error'] == UPLOAD_ERR_OK ) {
				return true;
			} else {
				$this->_error(__($this->uploadErrors[$this->file['error']], true));
			}
		}
		return false;
	}

/**
 * Checks the upload directory exists
 *
 * @return void
 */
	private function checkUploadDir() {
		if (isset($this->settings['uploadDir']) && !empty($this->settings['uploadDir'])) {
			if ($this->settings['useWWWROOT']) {
				$this->settings['uploadDir'] = WWW_ROOT . $this->settings['uploadDir'] . DS;
			} else {
				$this->settings['uploadDir'] = $this->settings['useWWWROOT'] . $this->settings['uploadDir'] . DS;
			}
			$dir = new Folder();
			if (!$dir->create($this->settings['uploadDir'], 0766)) {
				$this->_error(implode(', ', $dir->errors()));
				return false;
			}
			return true;
		}
		return false;
	}

/**
 * Check file exists
 *
 * @param $file The file name to be checked
 * @return bool
 */
	private function fileUploaded($file = null) {
		$this->setFile($file);
		return array_key_exists('tmp_name', $this->file) && !empty($this->file['tmp_name']);
	}

/**
 * Returns the file extension of the file
 *
 * @param $file the file name
 * @return $ext The file extension
 */
	private function _ext($file = false) {
		$this->setFile($file);
		return strrchr($this->file['name'],".");
	}

/**
 * Get errors
 * 
 * @param string $sep seperate the string
 * @return string
 */ 
	public function getErrors($sep = '<br/>') {
		$out = '';
		foreach($this->errors as $error){
			$out = "$error $sep";
		}
		return $out;
	}
	
/**
 * Add errors to the error array
 * 
 * @param $text 
 * @return void
 */ 
	private function _error($text) {
		$this->errors[] = $text;
	}

}