<?php echo $this->Form->input('email', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Email'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'disabled' => 'disabled')); ?>
<?php echo $this->Form->input('name', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Business name'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('address', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Address'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'value' => ''));?>
<?php echo $this->Form->input('phone', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Phone'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('abn', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('A.B.N.'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('billingrate', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Default billing rate'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Company Logo');?></label>
	<div class="col-md-10">
		<?php echo $this->Form->input('Image.logo', array('type' => 'file', 'data-style' => 'fileinput', 'div' => false, 'label' => false));?>
		<div class="avatar">
			<?php if( empty($this->data['Client']['logo']) ) { 
				echo $this->Html->image('avatar-1.jpg', array('alt' => ''));
			} else {
				echo $this->Resize->image($this->data['Client']['logo'], 120, 120, true, array('alt' => ''));
				echo $this->Html->link('<span class="fa-stack fa-lg"><i class="fa fa-camera fa-stack-1x text-default"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span>', array('controller' => 'clients', 'action' => 'removeLogo', $this->data['Client']['id'], 'plugin' => false), array('escape' => false));
			}?>
		</div>
	</div>
</div>
<?php echo $this->Form->input('tax_id', array('class' => 'form-control select2', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Tax')), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'div' => 'form-group', 'empty' => ''));?>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Active Users');?></label>
	<div class="col-md-10">
		<span class="form-control"><strong><?php echo count($this->data['User']);?></strong> <?php echo $this->Html->link(__('Manage Users'), array('controller' => 'users', 'action' => 'index'), array('class' => 'btn btn-sm btn-default pull-right', 'escape' => false));?></span>
	</div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Date Joined');?></label>
	<div class="col-md-10">
		<span class="form-control"><strong><?php echo $this->Time->nice($this->data['Client']['created']);?></strong></span>
	</div>
</div>

<?php echo $this->start('panel-footer');?>
<div class="panel-footer">
	<div class="row">
		<div class="col-md-6 col-md-offset-2">
			<div class="btn-toolbar">
				<?php echo $this->Form->submit('Save', array('class'=>'btn btn-primary', 'div' => false)); ?>
				<?php echo $this->Html->link('Cancel', array('controller' => 'clients', 'action' => 'cancel', 'plugin' => false), array('class' => 'btn btn-default')); ?>
				<?php echo $this->Form->hidden('id');?><?php echo $this->Form->hidden('client_meta');?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->end();?>
<?php echo $this->Html->css(array('plugins/select2.min.css'), array('inline' => false));?>
<?php echo $this->Html->script(array(
'plugins/bootstrap-typeahead/bootstrap-typeahead.min', 
'plugins/select2/select2.min.js',
), array('inline' => false));?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function() {
    $('.select2').select2();
});", array('inline' => false));?>