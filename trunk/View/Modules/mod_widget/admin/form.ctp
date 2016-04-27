
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('HTML Content');?></label>
	<div class="col-md-10">					
	</div>
</div>
<?php echo $this->Form->input('params.content', array('div' => 'form-group', 'label' => false, 'between' => '<div class="col-md-12">', 'after' => '</div>', 'type' => 'textarea', 'class' => 'form-control wysiwyg', 'rows' => 15));?>