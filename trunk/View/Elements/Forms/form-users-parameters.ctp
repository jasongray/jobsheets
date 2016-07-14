<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('User Image');?></label>
	<div class="col-md-10">
		<?php echo $this->Form->input('Image.file', array('type' => 'file', 'data-style' => 'fileinput', 'div' => false, 'label' => false));?>
		<div class="avatar">
		<?php if( empty($this->data['User']['avatar']) ) { 
			echo $this->Html->image('avatar-1.jpg', array('alt' => ''));
		} else {
			echo $this->Resize->image($this->data['User']['avatar'], 80, 80, false, array('alt' => ''));
			echo $this->Html->link('<span class="fa-stack fa-lg"><i class="fa fa-camera fa-stack-1x text-default"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span>', array('controller' => 'users', 'action' => 'removeAvatar', $this->data['User']['id'], 'plugin' => false), array('escape' => false));
		}?>
		</div>
	</div>
</div>
<?php echo $this->Form->input('role_id', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Role'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'empty' => '')); ?>
<?php echo $this->Form->input('status', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Active'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'empty' => '', 'options' => array(0 => 'No', 1 => 'Yes'))); ?>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Last Login');?></label>
	<div class="col-md-10">
		<?php if (!empty($this->data['User']['lastactive'])){ echo $this->Time->timeAgoInWords($this->data['User']['lastactive'], array('end' => '+1 year')); } else { echo __('Never'); } ?>
	</div>
</div>
<?php if($this->Session->read('Auth.User.role_id') == 1){ ?>
<?php echo $this->Form->input('client_id', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Client'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'empty' => '')); ?>
<?php } else { ?>
<?php echo $this->Form->hidden('client_id', array('value' => $this->Session->read('Auth.User.client_id'))); ?>
<?php } ?>