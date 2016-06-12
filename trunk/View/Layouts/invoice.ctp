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
<?php echo $this->Html->docType(); ?>
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
    'css_invoices.min'));?>
	<?php echo $this->fetch('css');?>
</head>
<body>
    <div class="paper">
        <?php echo $this->fetch('content');?>
    </div>
</body>
</html>
