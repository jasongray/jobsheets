<?php
/**
 *	Menu Helper class file
 *
 *	Creates an HTML list menu
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
*	MenuHelper class for creation menu items
*
*	@package WebCart.Cake.View.Helper
*
*/
class MenuHelper extends AppHelper  {

/**
*	Reference to selected class
*
*	@var 	string
*/
	public $selected = '';

/**
*	Reference to HTML tags to use
*
*	@var 	array
*/
	public $tags = array(
		'ul' => '<ul%s>%s</ul>',
		'ol' => '<ol%s>%s</ol>',
		'li' => '<li%s>%s</li>',
		'span' => '<span%s>%s</span>',
	);

/**
*	Reference to settings
*
*	@var 	array
*/
	public $settings = array();

/**
*	CakePHP helpers to load
*
*	@var 	array
*/
	public $helpers = array('Html', 'Session');

/**
*	Constructor
*
*	@param View $view The View this helper is being attached to.
*	@param array $settings Configuration settings for the helper.
*
*/
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
	}



	public function create($menu_id = false, $attr = array(), $type = 'ul', $dropulclass = 'sub-menu', $dropliclass = '', $dropaclass = '', $liclass = false, $selected = false){

		$out = array();
	
		if ($selected) {
			$this->selected = $selected;
		}

		if(is_array($menu_id)) {
			foreach($menu_id as $m) {
				$out[] = $this->li($m, $dropulclass, $dropliclass, $dropaclass, $liclass);
			}
			$tmp = implode("\n", $out);

			return $this->ul($tmp, $attr);

		} else {
			if($_menu = $this->load($menu_id)) {
				$sub = (isset($attr['dropdown']) && !empty($attr['dropdown']))? $attr['dropdown']: '';
				foreach($_menu as $m) {
					$out[] = $this->li($m, $dropulclass, $dropliclass, $dropaclass, $liclass);
				}
			}
			$tmp = implode("\n", $out);

			return $this->ul($tmp, $attr);
			
		}
		
		return null;
	
	}
	
	private function ul($_link, $attr = '') {
		
		return $this->output(sprintf($this->tags['ul'], $this->_parseAttributes($attr), $_link));
		
	}
	
	private function li($_menuitem, $dropulclass = 'sub-menu', $dropliclass = '', $dropaclass = '', $liclass = false) {

		if ($_menuitem['MenuItem']['permissions'] >= $this->Session->read('Auth.User.role_id') || !isset($_menuitem['MenuItem']['permissions'])) {

			if ($_menuitem['MenuItem']['divider'] === '1') {
				return $this->output(sprintf($this->tags['li'], $this->_parseAttributes(array('class' => $_menuitem['MenuItem']['class'])), null));
			}
			$_link = $this->link($_menuitem, $dropaclass);
			$_class = array();
			// do this coz the li requires the class in the template.
			$url = $this->createurl($_menuitem);
			$attr = array();
			$test_url = (is_array($url))? $this->Html->url($url): $url;
			if (str_replace($this->base, '', $this->here) == str_replace($this->base, '', $test_url)) {
				$_class[] = $this->selected;
			}
			// -------------------- //

			if ($liclass) {
				$_class[] = $liclass;
			}
			
			if (count($_menuitem['children']) > 0) {
				$out = array();
				foreach($_menuitem['children'] as $m) {
					$out[] = $this->li($m, $dropulclass, $dropliclass, $dropaclass, $liclass);
				}
				$tmp = implode("\n", $out);
				$subul = $this->ul($tmp, array('class' => $dropulclass));
				if (!empty($dropliclass)) {
					$_class[] = $dropliclass;
				}
				if(preg_match('/admin/', $this->Html->url($url))) {
					$_link = $_link . $subul;
				} else {
					if (preg_match('/\"'.$this->selected.'\"/', $subul)) {
						$_class[] = 'open';
						//$_link = str_replace('<span class="submenu-icon"><span class="glyphicon glyphicon-chevron-down"></span></span>', '', $_link);
					}
					$_link = $_link . $subul;
				}
				
			}
			$attr = array('class' => implode(' ', $_class));
			return $this->output(sprintf($this->tags['li'], $this->_parseAttributes($attr), $_link));

		}
		
	}
	
	
	private function link($l, $dropaclass = '') {
		
		$url = $this->createurl($l);
		$attr = array();
		/*  this is not required here for this template
		$test_url = (is_array($url))? $this->Html->url($url): $url;
		if (str_replace($this->base, '', $this->here) == str_replace($this->base, '', $test_url)) {
			$attr = array('class' => $this->selected);
		}
		*/
		if (isset($l['MenuItem']['iclass']) && !empty($l['MenuItem']['iclass'])) {
			$i = '<i class="' . $l['MenuItem']['iclass'] . '"></i>';
		} else {
			$i = '';
		}
		$attr = array_merge(array('escape' => false), $attr);

		if (isset($l['MenuItem']['class']) && !empty($l['MenuItem']['class'])) {
			$attr = array_merge(array('class' => $l['MenuItem']['class']), $attr);
		}
		
		$prepend = '';
		if (count($l['children']) > 0) {
			$attr = array_merge(array('escape' => false, 'class' => 'dropdown-toggle js-activated'), $attr);
			if(!is_array($url) && preg_match('/admin/', $url)) {
				$prepend = '<i class="arrow icon-angle-left"></i>';
			}
			$url = 'javascript:void(0);';
		}

		if (count($l['children']) > 0 && !empty($dropaclass)) {
			$attr = array_merge(array('class' => $dropaclass), $attr);
		}
		
		
		return $this->Html->link($i . $this->Html->tag('span', $l['MenuItem']['title']) . $prepend, $url, $attr);
		
	}
	
	
	private function load($menu_id) {
		
		$cache = Cache::read('menu_' . $menu_id, 'longterm');
		if (!$cache) {
			App::uses('MenuItem', 'Model');
			$this->_MenuItem = new MenuItem();
			$list = $this->_MenuItem->find('threaded', array('conditions' => array('MenuItem.menu_id' => $menu_id, 'MenuItem.published' => 1), 'order' => 'MenuItem.lft ASC'));
			Cache::write('menu_' . $menu_id, $list, 'longterm');
		} else {
			$list = $cache;
		}
		return $list;
		
	}
	
	private function createurl($l, $action = 'index') {
		$url = array();
		
			if (!empty($l['MenuItem']['controller'])) {
				$url['controller'] = $l['MenuItem']['controller'];
				if (!empty($l['MenuItem']['action'])) {
					$url['action'] = $l['MenuItem']['action'];
					if(preg_match('/admin/', $url['action'])) {
						$url['admin'] = 'admin';
					}
				} else {
					$url['action'] = 'index';
				}
				if (!empty($l['MenuItem']['slug'])) {
					$url['id'] = $l['MenuItem']['slug'];
					if(!empty($l['MenuItem']['alias'])) {
						$url['slug'] = str_replace(' ', '-', $l['MenuItem']['alias']);
					}
				}
				if (!empty($l['MenuItem']['named'])) {
					$__named = preg_split('/\:/', $l['MenuItem']['named']);	
					$url[$__named[0]] = $__named[1];
				}
				$url['plugin'] = false;
			} elseif (!empty($l['MenuItem']['url'])) {
				$url = $l['MenuItem']['url'];
			}
			
			if ($l['MenuItem']['default'] == 1) {
				$url = '/';
			}
			
			if (empty($l['MenuItem']['url'])) {
				App::uses('MenuItem', 'Model');
				$this->_MenuItem = new MenuItem();
				$this->_MenuItem->id = $l['MenuItem']['id'];
				$this->_MenuItem->saveField('url', str_replace($this->base, '', $this->Html->url($url)));
			}
					
			/* just for this template */
			if (count($l['children']) > 0 && !is_array($url)) {
				if(preg_match('/admin/', $url)) {
					$url = '/admin/javascript:void(0);';
				} else {
					$url = 'javascript:void(0);';
				}
			}
		
		return $url;
	}

}
	