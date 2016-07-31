<?php echo $this->Form->input('email', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Email'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>	
<?php echo $this->Form->input('password', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Password'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'value' => ''));?>
<?php echo $this->Form->input('firstname', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Firstname'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('lastname', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Surname'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('phone', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Phone Number'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('billingrate', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Charge Rate'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>

<?php echo $this->start('panel-footer');?>
<div class="panel-footer">
	<div class="row">
		<div class="col-md-5 col-md-offset-2">
			<div class="btn-toolbar">
				<?php echo $this->Form->submit('Save', array('class'=>'btn btn-primary', 'div' => false)); ?>
				<?php echo $this->Html->link('Cancel', array('controller' => 'users', 'action' => 'cancel', 'plugin' => false), array('class' => 'btn btn-default')); ?>
			</div>
		</div>
		<div class="col-md-5">
			<div class="btn-toolbar">
				<?php echo $this->Form->hidden('client_id', array('value' => $this->Session->read('Auth.User.client_id'))); ?>
				<?php echo $this->Form->hidden('client_meta', array('value' => $this->Session->read('Auth.User.client_meta'))); ?>
				<?php if(!empty($this->data['User']['id'])){ ?>
					<?php echo $this->Form->hidden('id');?>
					<?php echo $this->Html->link('Delete', array('controller' => 'users', 'action' => 'delete', 'plugin' => false, $this->data['User']['id'], ), array('class' => 'btn btn-danger pull-right')); ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->end();?>

<?php echo $this->element('Forms/form-javascript');?>