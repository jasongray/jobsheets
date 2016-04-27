<?php $this->Html->pageClass = 'permissions';?>
<?php $this->Html->pageTitle = 'Permissions';?>

<?php echo $this->Html->css('/acl/css/acl.css', array('block' => 'css'));?>
<?php echo $this->Html->script('/acl/js/jquery');?>
<?php echo $this->Html->script('/acl/js/acl_plugin');?>
<?php echo $this->Html->scriptBlock("var jQ164 = $.noConflict(true);")?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h4><i class="fa fa-pushpin"></i> <?php echo __('ACL Plugin');?></h4>
			</div>
			<div class="panel-body">
	
	<?php
	echo $this->Session->flash('plugin_acl');
	?>
	
	<?php

	if(!isset($no_acl_links))
	{
	    $selected = isset($selected) ? $selected : $this->params['controller'];
    
        $links = array();
        $links[] = $this->Html->link(__d('acl', 'Permissions'), array('controller' => 'aros', 'action' => 'index', 'plugin' => 'acl'), array('class' => ($selected == 'aros' )? 'selected' : null));
        $links[] = $this->Html->link(__d('acl', 'Actions'), array('controller' => 'acos', 'action' => 'index', 'plugin' => 'acl'), array('class' => ($selected == 'acos' )? 'selected' : null));
        
        echo $this->Html->nestedList($links, array('class' => 'acl_links'));
	}
	?>