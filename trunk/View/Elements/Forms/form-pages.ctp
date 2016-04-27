<?php echo $this->Form->input('title', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Title'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Show Title');?></label>
	<div class="col-md-10">
		<?php echo $this->Form->input('show_title', array('div' => false, 'label' => false, 'class' => 'uniform', 'type' => 'checkbox')); ?>
	</div>
</div>
<?php echo $this->Form->input('subheader', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Subheading'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Show Subheader');?></label>
	<div class="col-md-10">
		<?php echo $this->Form->input('show_subheader', array('div' => false, 'label' => false, 'class' => 'uniform', 'type' => 'checkbox')); ?>
	</div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Publish');?></label>
	<div class="col-md-10">
		<?php echo $this->Form->input('published', array('div' => false, 'label' => false, 'class' => 'uniform', 'type' => 'checkbox')); ?>
	</div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Home Page Article');?></label>
	<div class="col-md-10">
		<?php echo $this->Form->input('front_page', array('div' => false, 'label' => false, 'class' => 'uniform', 'type' => 'checkbox')); ?>
	</div>
</div>
<div class="form-group">
	<?php echo $this->Form->input('content', array('div' => false, 'label' => array('text' => __('Content'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'type' => 'textarea', 'class' => 'form-control wysiwyg', 'rows' => 27));?>
</div>
<div class="form-actions">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('class'=>'btn btn-primary', 'div' => false)); 
	echo $this->Html->link('Cancel', array('controller' => 'pages', 'action' => 'cancel', 'plugin' => false), array('class' => 'btn btn-orange'));
	if(!empty($this->data['Page']['id'])){
		echo $this->Html->link('Delete', array('controller' => 'pages', 'action' => 'delete', 'plugin' => false, $this->data['Page']['id']), array('class' => 'btn btn-grey'));
	}
?>	
</div>
<?php echo $this->element('Forms/form-javascript');?>