<?php echo $this->Form->input('email', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Email'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>	
<?php echo $this->Form->input('password', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Password'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'value' => ''));?>
<?php echo $this->Form->input('firstname', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Firstname'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('lastname', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Surname'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('phone', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Phone Number'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('billingrate', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Charge Rate'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>

<?php echo $this->start('panel-footer');?>
<div class="panel-footer">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('class'=>'btn btn-primary', 'div' => false)); 
	echo $this->Html->link('Cancel', array('controller' => 'users', 'action' => 'cancel', 'plugin' => false), array('class' => 'btn btn-default'));
	if(!empty($this->data['User']['id'])){
		echo $this->Html->link('Delete', array('controller' => 'users', 'action' => 'delete', 'plugin' => false, $this->data['User']['id']), array('class' => 'btn btn-danger'));
	}
?>	
</div>
<?php echo $this->end();?>

<?php echo $this->element('Forms/form-javascript');?>