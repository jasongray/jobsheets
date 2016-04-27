<?php 

/**
 *	mod_menuHelper class
 *
 *
 */

class mod_usermenu  {

	public function getMenus() {
		App::uses('Menu', 'Model');
		$this->Menu = new Menu;
		$menu = $this->Menu->find('all', array('conditions' => array('Menu.published' => 1)));
		$options = array();
		if ($menu) {
			foreach ($menu as $m) {
				if (!empty($m['Menu'])) {
					$options[$m['Menu']['id']] = $m['Menu']['title'];
				}
			}
		}
		return $options;
	}

}
?>