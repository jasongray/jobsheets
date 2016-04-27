<?php echo $this->Form->input('User.role_id', array('div' => 'form-group', 'class' => 'select2-select-00 col-md-12 full-width-fix', 'label' => array('text' => __('Role'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'empty' => '')); ?>
<?php echo $this->Form->input('User.active', array('div' => 'form-group', 'class' => 'select2-select-00 col-md-12 full-width-fix', 'label' => array('text' => __('Active'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'empty' => '', 'options' => array(0 => 'No', 1 => 'Yes'))); ?>
<?php echo $this->Form->input('email', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Email'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<hr/>
<div class="form-group">	
	<?php echo $this->Form->input('firstname', array('div' => false, 'class' => 'form-control', 'label' => array('text' => __('Firstname'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-3">', 'after' => '</div>')); ?>
	<?php echo $this->Form->input('surname', array('div' => false, 'class' => 'form-control', 'label' => array('text' => __('Surname'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-3">', 'after' => '</div>')); ?>
</div>
<?php echo $this->Form->input('address1', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Address 1'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('address2', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Address 2'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<div class="form-group">
	<?php echo $this->Form->input('suburb', array('div' => false, 'class' => 'form-control', 'label' => array('text' => __('Suburb'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-2">', 'after' => '</div>')); ?>
	<?php echo $this->Form->input('state', array('div' => false, 'class' => 'form-control', 'label' => array('text' => __('State'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-1">', 'after' => '</div>')); ?>
	<?php echo $this->Form->input('postcode', array('div' => false, 'class' => 'form-control', 'label' => array('text' => __('Postcode'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-1">', 'after' => '</div>')); ?>
</div>
<?php echo $this->Form->input('country_id', array('div' => 'form-group', 'class' => 'select2-select-00 col-md-12 full-width-fix', 'label' => array('text' => __('Country'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'empty' => '')); ?>
<?php echo $this->Form->input('phone', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Phone'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Newsletter');?></label>
	<div class="col-md-10">
		<?php echo $this->Form->input('newsletter', array('div' => false, 'label' => false, 'class' => 'uniform', 'type' => 'checkbox')); ?>
	</div>
</div>
<div class="form-actions">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('class'=>'btn btn-primary', 'div' => false)); 
	echo $this->Html->link('Cancel', array('controller' => 'customers', 'action' => 'cancel', 'plugin' => false), array('class' => 'btn btn-orange'));
	if(!empty($this->data['Customer']['id'])){
		echo $this->Html->link('Delete', array('controller' => 'customers', 'action' => 'delete', 'plugin' => false, $this->data['Customer']['id']), array('class' => 'btn btn-grey'));
	}
?>	
</div>
<?php echo $this->element('Forms/form-javascript');?>