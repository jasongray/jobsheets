<?php
/**
 * User model.
 *
 * User model-related methods here.
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
 * @package       JobSheet.Model
 * @since         JobSheets v 0.0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppModel', 'Model');

/**
 * Module model for JobSheets.
 *
 * @package       JobSheets.Model
 */

class Module extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';
	
	
	public function getModules($position = false, $tpl = 'default', $params = array()) {
		if ($position) {
			$cache = Cache::read('getModules_' . $position . '_' . $tpl, 'longterm');
			if (!$cache) {
				if (!isset($params['params']['id'])) {
					$params['params']['id'] = 0;
				}
				$_conditions = array("IF(Module.menus = 2, FIND_IN_SET({$params['params']['id']}, Module.menuselections), 1 = 1)");
				$_conditions = array_merge(array('Module.published' => 1, 'Module.position' => $position), $_conditions);
				$result = $this->find('all', array(
					'fields' => array(
						'title',
						'show_title',
						'params',
						'idclass',
						'class',
						'header',
						'header_class',
						'module_file',
						),
					'conditions' => $_conditions, 
					'order' => 'Module.ordering ASC'));
				Cache::write('getModules_' . $position . '_' . $tpl, $result, 'longterm');
				return $result;
			} else {
				return $cache;
			}
		}
	}

	public function beforeSave($options = array()) {
		if (isset($this->data['Module']['module_file'])) {
			$helper = $this->loadHelper($this->data['Module']['module_file']);
			if ($helper && method_exists($helper, 'save')) {
				$this->data = $helper->save($this->data);
			}
			if (isset($this->data['params']) && !empty($this->data['params'])) {
				$this->data['Module']['params'] = json_encode($this->data['params']);
			}
		}
		return true;
	}
	

	private function loadHelper($_m) {
		$_path = APP . 'View' . DS;
		$_folder = (Configure::read('MySite.theme'))? 'Themed' . DS . Configure::read('MySite.theme') . DS . 'Modules': 'Modules';
		$_mod_folder = DS . $_m . DS . 'admin' . DS;
		if (file_exists($_path . $_folder . $_mod_folder . 'helper.php')) {
			include_once $_path . $_folder . $_mod_folder . 'helper.php';
			return new $_m;
		} else if (file_exists($_path . 'Modules' . $_mod_folder . 'helper.php')) {
			include_once $_path . 'Modules' . $_mod_folder . 'helper.php';
			return new $_m;
		}
		return false;
	}
	
}
