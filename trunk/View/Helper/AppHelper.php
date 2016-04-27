<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper {

	public function jobStatus($sts = null) {
		$html = sprintf('<span class="%s">%s</span>', 'label label-warning', __('Unallocated'));
		switch ($sts) {
			case '9':
				$html = sprintf('<span class="%s">%s</span>', 'label label-inverse', __('Cancelled'));
				break;
			case '8':
				$html = sprintf('<span class="%s">%s</span>', 'label label-success', __('Completed'));
				break;
			case '3':
				$html = sprintf('<span class="%s">%s</span>', 'label label-default', __('Draft'));
				break;
			case '2':
				$html = sprintf('<span class="%s">%s</span>', 'label label-primary', __('Tasked'));
				break;
			case '1':
				$html = sprintf('<span class="%s">%s</span>', 'label label-info', __('Allocated'));
				break;
		}
		return $html;
	}

}
