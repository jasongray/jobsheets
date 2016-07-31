<?php $this->Html->pageClass = 'users';?>
<?php $this->Html->pageTitle = __('My User Profile');?>
<?php $this->Html->addCrumb(__('Users'), array('controller' => 'users', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('My Profile'));?>
<?php echo $this->Form->create('User', array('class' => 'form-horizontal row-border', 'type' => 'file'));?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4><i class="fa fa-user"></i> <?php echo __('My Profile');?></h4>
			</div>
			<div class="panel-body">
				<div class="form-horizontal row-border">
					<?php echo $this->Form->input('email', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Email'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>	
					<?php echo $this->Form->input('password', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Password'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'value' => ''));?>
					<?php echo $this->Form->input('firstname', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Firstname'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
					<?php echo $this->Form->input('lastname', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Surname'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
					<?php echo $this->Form->input('phone', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Phone Number'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
					<div class="form-group">
						<label class="col-md-2 control-label"><?php echo __('User Image');?></label>
						<div class="col-md-10">
							<?php echo $this->Form->input('Image.file', array('type' => 'file', 'data-style' => 'fileinput', 'div' => false, 'label' => false));?>
							<div class="avatar">
							<?php if( empty($this->data['User']['avatar']) ) { 
								echo $this->Html->image('avatar-1.jpg', array('alt' => ''));
							} else {
								echo $this->Resize->image($this->data['User']['avatar'], 80, 80, true, array('alt' => ''));
								echo $this->Html->link('<span class="fa-stack fa-lg"><i class="fa fa-camera fa-stack-1x text-default"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span>', array('controller' => 'users', 'action' => 'removeAvatar', $this->data['User']['id'], 'plugin' => false), array('escape' => false));
							}?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-2">
						<div class="btn-toolbar">
						<?php
							echo $this->Form->hidden('id');
							echo $this->Form->submit('Save', array('class'=>'btn btn-primary', 'div' => false)); 
							echo $this->Html->link('Cancel', array('controller' => 'users', 'action' => 'cancel', 'plugin' => false), array('class' => 'btn btn-default'));
						?>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php /* 
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4><i class="fa fa-user"></i> <?php echo __('Notification Settings');?></h4>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-md-2 control-label"><?php echo __('Jobs');?></label>
					<div class="col-md-10">
						<?php echo $this->Form->input('User.settings.notifications.jobs[]', array('type' => 'checkbox', 'div' => false, 'class' => 'form-control', 'label' => array('text' => __('Email'), 'class' => 'control-label col-md-3'), 'before' => '<div class="col-md-2">', 'after' => '</div>')); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
*/ ?>
<?php echo $this->Form->end();?>