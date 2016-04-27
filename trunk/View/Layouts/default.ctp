<?php
/**
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
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $this->fetch('title'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
		echo $this->Html->meta('icon');
		echo $this->fetch('meta');
	?>
	<?php echo $this->Html->css(array(
    'http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css',
    'css_styles.min'));?>
	<?php echo $this->fetch('css');?>
</head>
<body>
	<div id="headerbar">

	</div>
	<header class="navbar navbar-inverse navbar-fixed-top" role="banner">
        <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>
        <a id="rightmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="left" title="Toggle Infobar"></a>

        <div class="navbar-header pull-left">
        	<?php echo $this->Html->link($this->Html->image('jobsheets-logo-sm.png', array('alt' => __('JobSheets'))), '/', array('class' => 'navbar-brand', 'escape' => false));?>
        </div>

        <?php echo $this->Module->load('usermenu');?>
    </header>

    <div id="page-container">

    	<nav id="page-leftbar" role="navigation">
    		<?php echo $this->Module->load('navigation');?>
    	</nav>

    	<div id="page-content">
    		<div id="wrap">
    			<div id="page-heading">
    				<?php echo $this->Module->load('breadcrumbs');?>
    				<?php echo $this->Html->tag('h1', h($this->fetch('title')));?>
    			</div>

    			<div class="container">
    				<?php echo $this->Flash->render(); ?>
    				<?php echo $this->fetch('content'); ?>
    			</div>

    		</div>
    	</div>

    	<footer role="contentinfo">
    		<div class="clearfix">
    			<ul class="list-unstyled list-inline pull-left">
    				<li>JobSheets &copy; <?php echo date('Y');?></li>
                    <li>Version 2016.1.0a</li>
    			</ul>
    			<button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
    		</div>
    	</footer>

    </div>
    <?php echo $this->Html->script(array(
    'jquery-1.10.2.min', 
    'jqueryui-1.10.3.min', 
    'bootstrap.min', 
    'enquire',
    'application'));?>
	<?php 
		echo $this->fetch('script');
		echo $this->element('sql_dump'); 
        //pr($this->Session->read('Auth.User'));
        //pr($__cookie);
	?>
</body>
</html>
