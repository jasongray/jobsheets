<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
				<div class="col-md-12">
					<p class="text-center">
						<span class="text-info" style="font-size:4em;"><?php echo __('Uh-oh');?></span>
					</p>
					<p class="text-center"><?php echo __('It looks like you have taken a wrong turn');?></p>
					<p class="text-center"><?php echo $message; ?></p>
				</div>
				<div class="col-md-4 col-md-offset-4">
					<?php
					if (Configure::read('debug') > 0):
						echo $this->element('exception_stack_trace');
					endif;
					?>
				</div>
