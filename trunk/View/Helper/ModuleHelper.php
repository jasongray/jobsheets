<?php
App::uses('Helper', 'View');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Module helper
 *
 * Manages module rendering for Webwidget CMS
 *
 * @package       app.View.Helper
 */
class ModuleHelper extends AppHelper{
	
	var $helpers = array('Html', 'Form', 'Session', 'Paginator', 'Resize', 'Xhtml', 'Menu', 'Number', 'Time', 'Img');
	
	public function load($position = false, $tpl = false, $xt = false) {
		if ($position) {
			if ($tpl) { 
				$tpl = $tpl . '.ctp';
			} else {
				$tpl = $position . '.ctp';
			}
			$result = '';
			$__params = (!empty($this->_View->viewVars))? $this->_View->viewVars: array();
			$cache = Cache::read('modulesLoad_' . $position . '_' . $tpl . '_' . $this->request->url, 'longterm');
			if (!$cache) {
				App::uses('Module', 'Model');
				$this->Module = new Module;
				$modules = $this->Module->getModules($position, $tpl . '_' . $this->request->url, $__params);
				Cache::write('modulesLoad_' . $position . '_' . $tpl . '_' . $this->request->url, $modules, 'longterm');
			} else {
				$modules = $cache;
			}
			if (!empty($modules)) {
				$_path = APP . 'View' . DS;
				for ($i=0;$i<count($modules);$i++) {
					$m = $modules[$i];
					$module_file = $m['Module']['module_file'];
					$m['Module']['count'] = count($modules);
					unset($m['Module']['module_file']); // view file does not require this
					if (isset($m['Module']['params'])) {
						$m['Module'] = array_merge_recursive($m['Module'], json_decode($m['Module']['params'], true));
						unset($m['Module']['params']);
					}
					echo $this->_render($_path . $this->checkFolder($module_file) . DS . 'tmpl' . DS . 'default.ctp', $__params, array('m' => $m['Module'], 'helper' => $this->loadHelper($module_file)));
				}
				
			}
			
		}
		return null;
	}
	
	public function has($position = false, $tpl = 'default') {
		
		if ($position) {
			if ($tpl) { 
				$tpl = $tpl . '.ctp';
			} else {
				$tpl = $position . '.ctp';
			}
			$__params = (!empty($this->_View->viewVars))? $this->_View->viewVars: array();
			App::uses('Module', 'Model');
			$this->Module = new Module;
			$result = $this->Module->getModules($position, $tpl . '_' . $this->request->url, $__params);
			if (count($result) > 0) {
				return true;
			}
		}
		return false;
	}

	public function loadparamsform($mod = false) {
		$_path = APP . 'View' . DS;
		$_folder = 'Modules';
		if (file_exists($_path . $_folder . DS . $mod)) {			
			if (file_exists($_path . $_folder . DS . $mod . DS . 'admin' . DS . 'form.ctp')) {
				$helper = $this->loadHelper($mod);
				include_once $_path . $_folder . DS . $mod . DS . 'admin' . DS . 'form.ctp';
			}
		}
		return ;
	}

	public function loadModel($model = false) {
		if ($model) {
			App::uses($model, 'Model');
			$this->$model = new $model;
		}
	}
	
	private function checkFolder($tpl = 'default') {
		$_path = APP . 'View' . DS;
		if (isset($this->request->params['prefix']) && $this->request->params['prefix'] === 'admin') {
			$_folder = 'Modules' . DS . $tpl;
		} else {
			$_folder = (Configure::read('MySite.theme'))? 'Themed' . DS . Configure::read('MySite.theme') . DS . 'Modules': 'Modules';
			if (file_exists($_path . $_folder . DS . $tpl)) {
				$_folder = $_folder . DS . $tpl;
			} elseif (file_exists($_path . 'Modules' . DS . $tpl)) {
				$_folder = 'Modules' . DS . $tpl;
			}
		}
		return $_folder;
	}
	
	public function loadHelper($mod = false) {
		$_path = APP . 'View' . DS;
		$_folder = 'Modules';
		$_folder = $_folder	. DS . $mod . DS . 'admin';
		if (file_exists($_path . $_folder . DS . 'helper.php')) {
			include_once $_path . $_folder  . DS . 'helper.php';
			return new $mod;
		}
	}
	
	private function _render($viewFile, $data = array(), $options = array()) {
		if (empty($data) && isset($this->_View->viewVars)) {
			$data = $this->_View->viewVars;
		}
		if (is_array($data)){ 
			extract($data);
		}
		if (is_array($options)){ 
			extract($options);
		}
		if (file_exists($viewFile)) {
			ob_start();
			include $viewFile;
			unset($viewFile);
			return ob_get_clean();
		}
	}
	
}