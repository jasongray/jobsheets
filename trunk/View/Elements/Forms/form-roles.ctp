<?php echo $this->Form->create('Role', array('class' => 'form-horizontal row-border', 'type' => 'file'));?>
<?php echo $this->Form->input('name', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Role'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<div class="panel-footer">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('class'=>'btn btn-primary', 'div' => false)); 
	echo $this->Html->link('Cancel', array('controller' => 'roles', 'action' => 'cancel', 'plugin' => false), array('class' => 'btn btn-default'));
	if(!empty($this->data['Role']['id'])){
		echo $this->Html->link('Delete', array('controller' => 'roles', 'action' => 'delete', 'plugin' => false, $this->data['Role']['id']), array('class' => 'btn btn-danger'));
	}
?>	
</div>
<?php echo $this->Form->end();?>
<?php echo $this->element('Forms/form-javascript');?>