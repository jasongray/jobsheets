<?php
/**
 * MenuItems controller.
 *
 * Controls specific individual menu items on each menu
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
 * @package       JobSheet.Controller
 * @since         JobSheets v 0.0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');
/**
 * MenuItems Controller
 *
 * @property MenuItem $MenuItem
 */
class MenuItemsController extends AppController {
	
	public function beforeFilter() {
	    parent::beforeFilter();
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$id = $this->request->params['named']['menu_id'];
		if (!$id) {
			$this->Flash->error('Invalid menu selected', true);
			$this->redirect($this->referer());
		}
		$this->MenuItem->recursive = -1;
		$rows = $this->MenuItem->find('all', array('conditions' => array('MenuItem.menu_id' => $id), 'order' => 'MenuItem.lft ASC'));
		
		$children = array();
		foreach ($rows as $v ){
			$pt = ($v['MenuItem']['parent_id'] == $id)? 0: $v['MenuItem']['parent_id'];
			$pt = ($v['MenuItem']['parent_id'] == '')? 0: $pt;
			$list = @$children[$pt] ? $children[$pt] : array();
			array_push( $list, $v );
			$children[$pt] = $list;
		}
		
		$list = $this->recurse(0, '', array(), $children, max(0, 10));
		$list = array_values($list);
		$this->set('data', $list);
		
		$menu_title = $this->MenuItem->Menu->find('first', array('conditions' => array('Menu.id' => $this->request->params['named']['menu_id'])));
		$this->set('menu_title', $menu_title['Menu']['title']);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MenuItem->recursive = 0;
			if(!empty($this->request->data['MenuItem']['named'])){
				$this->request->data['MenuItem']['slug'] = '';
			}
			$this->request->data['MenuItem']['named'] = '';
			$this->request->data['MenuItem']['alias'] = Inflector::slug(strtolower($this->request->data['MenuItem']['title']), '-');
			//$this->request->data['MenuItem']['controller'] = strtolower($this->request->data['MenuItem']['controller']);
			$this->request->data['MenuItem']['action'] = (isset($this->request->data['MenuItem']['action']))? strtolower($this->request->data['MenuItem']['action']): 'index';
			if($this->request->data['MenuItem']['controller'] === 'pages' && !preg_match('/admin/', $this->request->data['MenuItem']['action'])){
				$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
				$this->request->data['MenuItem']['action'] = 'display';
			}elseif($this->request->data['MenuItem']['controller'] === 'products'){
				$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
				if(empty($this->request->data['MenuItem']['action'])){
					$this->request->data['MenuItem']['action'] = 'view';
				}
			}elseif($this->request->data['MenuItem']['controller'] === 'categories'){
				if(!preg_match('/admin/', $this->request->data['MenuItem']['action'])) {
					if($this->request->data['MenuItem']['action'] == '0' || empty($this->request->data['MenuItem']['action'])){
						$this->request->data['MenuItem']['action'] = 'index';
					}else{
						$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
						$this->request->data['MenuItem']['action'] = 'view';
					}
				}
			}elseif($this->request->data['MenuItem']['controller'] === 'assets'){
				$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
				$this->request->data['MenuItem']['action'] = 'download';
			}elseif($this->request->data['MenuItem']['controller'] === 'projects'){
				if (preg_match('/category\:/', $this->request->data['MenuItem']['action'])) {
					$this->request->data['MenuItem']['named'] = $this->request->data['MenuItem']['action'];
					$this->request->data['MenuItem']['action'] = 'index';
					$this->request->data['MenuItem']['slug'] =  null;
				} elseif (is_numeric($this->request->data['MenuItem']['action'])) {
					$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
					$this->request->data['MenuItem']['action'] = 'view';
					$this->request->data['MenuItem']['named'] =  null;
				}
			}
			if (!empty($this->request->data['MenuItem']['params']['address_string'])) {
				$geocode = $this->Googlemap->geocode($this->request->data['MenuItem']['params']['address_string']);
				if ($geocode) {
					$this->request->data['MenuItem']['params']['lat'] = $geocode['lat'];
					$this->request->data['MenuItem']['params']['lng'] = $geocode['lng'];
				}
			}
			if (empty($this->request->data['MenuItem']['slug'])) {
				$this->request->data['MenuItem']['slug'] =  null;
			}
			if(empty($this->request->data['MenuItem']['action'])){
				$this->request->data['MenuItem']['action'] = 'index';
			}
			$this->request->data['MenuItem']['params'] = json_encode($this->request->data['MenuItem']['params']);
			$this->MenuItem->create();
			if ($this->MenuItem->save($this->request->data)) {
				$this->saveorder();
				$this->Flash->success('The menu item has been saved', true);
				$this->redirect(array('action' => 'index', 'menu_id' => $this->request->data['MenuItem']['menu_id']));
			} else {
				$this->Flash->error('The menu item could not be saved. Please, try again.', true);
			}
		}
		$links = $this->findControllers();
		$slugs = array();
		$_slug = '';
		$menus = $this->MenuItem->Menu->find('list');
		$parents = $this->MenuItem->generateTreeList(array('MenuItem.menu_id' => $this->request->params['named']['menu_id']));
		$this->set(compact('menus', 'parents', 'links', 'slugs', '_slug'));
		
		$menu_title = $this->MenuItem->Menu->find('first', array('conditions' => array('Menu.id' => $this->request->params['named']['menu_id'])));
		$this->set('menu_title', $menu_title['Menu']['title']);
		$this->setGroups();
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->MenuItem->id = $id;
		if (!$this->MenuItem->exists()) {
			throw new NotFoundException(__('Invalid menu item'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if(!empty($this->request->data['MenuItem']['named'])){
				$this->request->data['MenuItem']['slug'] = '';
			}
			$this->request->data['MenuItem']['named'] = '';
			$this->request->data['MenuItem']['alias'] = Inflector::slug(strtolower($this->request->data['MenuItem']['title']), '-');
			//$this->request->data['MenuItem']['controller'] = strtolower($this->request->data['MenuItem']['controller']);
			$this->request->data['MenuItem']['action'] = strtolower($this->request->data['MenuItem']['action']);
			if($this->request->data['MenuItem']['controller'] === 'pages' && !preg_match('/admin/', $this->request->data['MenuItem']['action'])){
				$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
				$this->request->data['MenuItem']['action'] = 'display';
			}elseif($this->request->data['MenuItem']['controller'] === 'products'){
				$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
				if(empty($this->request->data['MenuItem']['action'])){
					$this->request->data['MenuItem']['action'] = 'view';
				}
			}elseif($this->request->data['MenuItem']['controller'] === 'categories'){
				if(!preg_match('//', $this->request->data['MenuItem']['action'])) {
					if($this->request->data['MenuItem']['action'] == '0' || empty($this->request->data['MenuItem']['action'])){
						$this->request->data['MenuItem']['action'] = 'index';
					}else{
						$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
						$this->request->data['MenuItem']['action'] = 'view';
					}
				}
			}elseif($this->request->data['MenuItem']['controller'] === 'assets'){
				$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
				$this->request->data['MenuItem']['action'] = 'download';
			}elseif($this->request->data['MenuItem']['controller'] === 'projects'){
				if (preg_match('/category\:/', $this->request->data['MenuItem']['action'])) {
					$this->request->data['MenuItem']['named'] = $this->request->data['MenuItem']['action'];
					$this->request->data['MenuItem']['action'] = 'index';
					$this->request->data['MenuItem']['slug'] =  null;
				} elseif (is_numeric($this->request->data['MenuItem']['action'])) {
					$this->request->data['MenuItem']['slug'] = $this->request->data['MenuItem']['action'];
					$this->request->data['MenuItem']['action'] = 'view';
					$this->request->data['MenuItem']['named'] =  null;
				}
			}
			if (!empty($this->request->data['MenuItem']['params']['address_string']) && empty($this->request->data['MenuItem']['params']['lat']) && empty($this->request->data['MenuItem']['params']['lng'])) {
				$geocode = $this->Googlemap->geocode($this->request->data['MenuItem']['params']['address_string']);
				if ($geocode) {
					$this->request->data['MenuItem']['params']['lat'] = $geocode['lat'];
					$this->request->data['MenuItem']['params']['lng'] = $geocode['lng'];
				}
			}
			if (empty($this->request->data['MenuItem']['slug'])) {
				$this->request->data['MenuItem']['slug'] =  null;
			}
			if(empty($this->request->data['MenuItem']['action'])){
				$this->request->data['MenuItem']['action'] = 'index';
			}
			$this->request->data['MenuItem']['params'] = json_encode($this->request->data['MenuItem']['params']);
			if ($this->MenuItem->save($this->request->data)) {
				$this->saveorder();
				$this->Flash->success('The menu item has been saved', true);
				$this->redirect(array('action' => 'index', 'menu_id' => $this->request->data['MenuItem']['menu_id']));
			} else {
				$this->Flash->error('The menu item could not be saved. Please, try again.', true);
			}
		} else {
			$this->request->data = $this->MenuItem->read(null, $id);
			$this->request->data['MenuItem']['params'] = json_decode($this->request->data['MenuItem']['params'], true);
		}
		$links = $this->findControllers();
		$slugs = $this->findViews($this->request->data['MenuItem']['controller']);
		if ($this->request->data['MenuItem']['controller'] != 'projects') {
			$_slug = $this->request->data['MenuItem']['named'];
		} else {
			$_slug = $this->request->data['MenuItem']['slug'];
		}
		$menus = $this->MenuItem->Menu->find('list');
		$parents = $this->MenuItem->generateTreeList(array('MenuItem.menu_id' => $this->request->params['named']['menu_id']));
		$this->set(compact('menus', 'parents', 'links', 'slugs', '_slug'));
		
		$menu_title = $this->MenuItem->Menu->find('first', array('conditions' => array('Menu.id' => $this->request->params['named']['menu_id'])));
		$this->set('menu_title', $menu_title['Menu']['title']);
		$this->setGroups();
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->MenuItem->id = $id;
		if (!$this->MenuItem->exists()) {
			throw new NotFoundException(__('Invalid menu item'));
		}
		if ($this->MenuItem->delete()) {
			$this->Flash->success('Menu item deleted');
		} else {
			$this->Flash->error('Menu item was not deleted');
		}
		$this->redirect(array('action' => 'index', 'menu_id' => $this->request->params['named']['menu_id']));
	}
	
/**
 * cancel method
 *
 * @param string $id
 * @return void
 */
	function cancel($id = null) {
		$this->Flash->info(__('Operation cancelled', true));
		$this->redirect(array('action' => 'index', 'menu_id' => $this->request->params['named']['menu_id']));
	}

	
	function orderup($id = false){
		$this->autoRender = false;
		if($id){
			$this->MenuItem->moveUp($id, 1);
		}
		$this->redirect(array('action' => 'index', 'menu_id' => $this->request->params['named']['menu_id']));
	}
	
	function orderdown($id = false){
		$this->autoRender = false;
		if($id){
			$this->MenuItem->moveDown($id, 1);
		}
		$this->redirect(array('action' => 'index', 'menu_id' => $this->request->params['named']['menu_id']));
	}
	
	function saveorder(){
		$this->autoRender = false;
		$menu_id = $this->request->params['named']['menu_id'];
		//$treelist = $this->MenuItem->find('threaded', array('conditions' => array('MenuItem.menu_id' => $menu_id)));
		$treelist = $this->MenuItem->generateTreeList(array('MenuItem.menu_id' => $menu_id));
		if ($treelist) {
			$count = 1;
			foreach ($treelist as $id => $name) {
				$this->MenuItem->id = $id;
				$this->MenuItem->saveField('order', $count);
				$count++;
			}
			$this->MenuItem->Behaviors->attach('Tree', array(
			    'scope' => array(
			        'MenuItem.menu_id' => $menu_id,
			    ),
			));
			$this->MenuItem->id = null;
			$result = $this->MenuItem->reorder(array('id' => null, 'field' => 'order', 'order' => 'ASC'));
		}
		$this->redirect(array('action' => 'index', 'menu_id' => $menu_id));
		
	}
	
	function recover() {
		$this->autoRender = false;
		$menu_id = $this->request->params['named']['menu_id'];
		$this->MenuItem->Behaviors->attach('Tree', array(
		    'scope' => array(
		        'MenuItem.menu_id' => $menu_id,
		    ),
		));
		$this->MenuItem->recover('parent');
		$this->redirect(array('action' => 'index', 'menu_id' => $menu_id));
	}
	
	function getViews(){
		
		$this->layout = 'ajax';
		if(isset($this->request->params['named']['method'])){
			$this->set('options', $this->findViews($this->request->params['named']['method']));
		}
	}

	private function recurse( $id, $indent, $list, &$children, $maxlevel=9999, $level=0, $type=1 ){
		if (@$children[$id] && $level <= $maxlevel)
		{
			foreach ($children[$id] as $v)
			{
				$id = $v['MenuItem']['id'];

				if ( $type == 1 ) {
					$pre 	= '<sup>|_</sup>&nbsp;&nbsp;&nbsp;';
					$spacer = '&nbsp;&nbsp;&nbsp;&nbsp;';
				} else {
					$pre 	= '- ';
					$spacer = '...';
				}
				
				$list[$id]['MenuItem'] = $v['MenuItem'];
				
				$pt = ($v['MenuItem']['parent_id'] == $v['MenuItem']['menu_id'])? 0: $v['MenuItem']['parent_id'];
				if ( $pt == 0 ) {
					$list[$id]['MenuItem']['treename'] = $v['MenuItem']['title'];
				} else {
					$list[$id]['MenuItem']['treename'] = str_repeat($spacer, $level+1) . $pre . $v['MenuItem']['title'];
				}
				
				$list[$id]['MenuItem']['children'] = count( @$children[$id] );
				$list = $this->recurse( $id, $indent . $spacer, $list, $children, $maxlevel, $level+1, $type );
			}
		}
		return $list;
	}
	
	private function ampReplace( $text ){
		$text = str_replace( '&&', '*--*', $text );
		$text = str_replace( '&#', '*-*', $text );
		$text = str_replace( '&amp;', '&', $text );
		$text = preg_replace( '|&(?![\w]+;)|', '&amp;', $text );
		$text = str_replace( '*-*', '&#', $text );
		$text = str_replace( '*--*', '&&', $text );
		
		return $text;
	}
	
	private function findControllers(){
		App::uses('Sanitize', 'Utility');
		App::uses('Folder', 'Utility');
		App::uses('Inflector', 'Utility');
		$_path = ROOT . DS . APP_DIR . DS . 'Controller' . DS;
		$_folder = new Folder($_path);
		$_ignore = array(
			'AppController.php', 
			'RolesController.php', 
			'VisitsController.php',
			'Component',
			'empty', 
			'.DS_Store');
		$_list = $_folder->read(true, $_ignore);
		//$_path = Sanitize::escape($_path);
		$_f = array();
		foreach($_list[1] as $f){
			$_name = str_replace("Controller.php", '', str_replace($_path, '', $f));
			$_f[strtolower($_name)] = Inflector::humanize($_name);
		}
		return $_f;
	}
	
	private function findViews( $folder = false ){
		
		$_list = array();
		$_folder = array();
		$_admin = array(); 
		
		switch (strtolower($folder)){
			case 'pages':
				$this->loadModel('Page');
				$_list = $this->Page->find('list', array('fields' => array('Page.id', 'Page.title'), 'conditions' => array('Page.published' => 1)));
				//$_folder = $this->getcontents($folder, true);
				$_admin = $this->getcontents($folder, false);
			break;
			case 'categories':
				$this->loadModel('Category');
				$_list = $this->Category->find('list', array('fields' => array('Category.id', 'Category.title'), 'conditions' => array('Category.published' => 1)));
				$_folder = $this->getcontents($folder, true);
				$_admin = $this->getcontents($folder, false);
			break;
			case 'news':
				$_folder = $this->getcontents($folder, true);
				$_admin = $this->getcontents($folder, false);
			break;
			case 'products':
				//$this->loadModel('Product');
				//$_list = $this->Product->find('list', array('fields' => array('Product.id', 'Product.title'), 'conditions' => array('Product.published' => 1)));
				$_admin = $this->getcontents($folder, false);
			break;
			case 'projects':
				$_list = array();$_cat = array();$_pjt = array();
				$this->loadModel('Category');
				$_cats = $this->Category->find('list', array('fields' => array('Category.id', 'Category.title'), 'conditions' => array('Category.published' => 1)));
				foreach($_cats as $k => $v){
					$_cat['category:'.$k] = $v;
				}
				$this->loadModel('Project');
				$_projects = $this->Project->find('list', array('fields' => array('Project.id', 'Project.title'), 'conditions' => array('Project.published' => 1)));
				$_list = array_merge($_list, $_cat, $_projects);
				$_folder = $this->getcontents($folder, true);
				$_admin = $this->getcontents($folder, false);
			break;
			default: case 'modules': case 'funds': case 'users':
				$_folder = $this->getcontents($folder, false);
				$_admin = $this->getcontents($folder, false, array('modules.ini'), true);
			break;
		}
		
		return $_list + $_folder + $_admin;
		
	}
	
	private function getcontents($folder, $theme = true, $ignore = array(), $admin = false) {
		App::uses('Sanitize', 'Utility');
		App::uses('Folder', 'Utility');
		$_folder = (Configure::read('MySite.theme') && $theme)? 'Themed' . DS . Configure::read('MySite.theme') . DS : '' ;
		$_path = APP . 'View' . DS . $_folder . ucwords($folder);
		$_folder = new Folder($_path);
		$_ignore = array_merge($ignore, array(
			'Errors',
			'Elements', 
			'Helpers',
			'Layouts',
			'Scaffolds',
			'Components',
			'.DS_Store')
		);
		$_list = $_folder->tree($_path, $_ignore);
		$_f = array();
		foreach($_list[1] as $f){
			if ($admin) {
				if (!empty($f) && @strpos($f, '')) {
					$_name = str_replace(array('\\', '/'), '', str_replace(".ctp", '', str_replace($_path, '', $f)));
					$_f[$_name] =  $_name;
				}
			} else {
				$_name = str_replace(array('\\', '/'), '', str_replace(".ctp", '', str_replace($_path, '', $f)));
				$_f[$_name] = $_name;
			}
		}
		return $_f;
	}
	

	private function setGroups() {
		App::uses('Role', 'Model');
		$this->Role = new Role();
		$this->set('_groups', $this->Role->find('list', array('order' => array('id' => 'ASC'))));
	}
	
}
