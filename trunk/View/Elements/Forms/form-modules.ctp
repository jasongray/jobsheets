<?php echo $this->Form->input('title', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Module Title'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Show Title');?></label>
	<div class="col-md-10">
		<?php echo $this->Form->input('show_title', array('div' => false, 'label' => false, 'class' => 'uniform', 'type' => 'checkbox')); ?>
	</div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Publish');?></label>
	<div class="col-md-10">
		<?php echo $this->Form->input('published', array('div' => false, 'label' => false, 'class' => 'uniform', 'type' => 'checkbox')); ?>
	</div>
</div>
<?php echo $this->Form->input('position', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Position'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'options' => $positions, 'empty' => '')); ?>
<?php echo $this->Form->input('class', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Module Class'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('idclass', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('ID'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>'));?>
<?php echo $this->Form->input('header', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Header'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'options' => array('h1' => 'h1', 'h2' => 'h2', 'h3' => 'h3', 'h4' => 'h4', 'h5' => 'h5'), 'empty' => '')); ?>
<?php echo $this->Form->input('header_class', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Header Class'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<hr/>
<h5><?php echo __('Menu Assignment', true);?></h5>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Select which menu to show this module on');?></label>
	<div class="col-md-10">
		<?php echo $this->Form->input('menus', array('div' => false, 'legend' => false, 'class' => 'uniform menus', 'options' => array('All', 'None', 'Selection from list'), 'type' => 'radio', 'before' => '<div class="radio-inline">', 'after' => '</div>', 'separator' => '</div><div class="radio-inline">'));?>								
	</div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Menu Selection');?></label>
	<div class="col-md-10">
	<?php $disabled = (!empty($this->data['Module']['menus']) && $this->data['Module']['menus'] != 2)? 'disabled': '';?>
<?php echo $this->Form->input('menuselections', array('div' => 'field', 'type' => 'select', 'options' => $menuselections, 'multiple' => true, 'label' => false, 'size' => '15', 'class' => 'multiple', 'disabled' => $disabled));?>
	</div>
</div>
<div class="panel-footer">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->hidden('module_file');
	echo $this->Form->submit('Save', array('class'=>'btn btn-primary', 'div' => false)); 
	echo $this->Html->link('Cancel', array('controller' => 'modules', 'action' => 'cancel', 'plugin' => false), array('class' => 'btn btn-default'));
	if(!empty($this->data['Module']['id'])){
		echo $this->Html->link('Delete', array('controller' => 'modules', 'action' => 'delete', 'plugin' => false, $this->data['Module']['id']), array('class' => 'btn btn-danger'));
	}
?>	
</div>
<?php echo $this->element('Forms/form-javascript');?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function($){
	$('input.menus').click(function(e){
		var menus = $(this).val();
		if (menus == 0) {
			/*$('#ModuleMenuselections > option').prop('selected', 'selected');*/
			$('#ModuleMenuselections').find('option').each(function() {
				$(this).attr('selected', 'selected');
			});
			$('#ModuleMenuselections').attr('disabled', 'disabled');
		}
		if (menus == 1) {
			$('#ModuleMenuselections').find('option').each(function() {
				$(this).prop('selected', false);
			});
			$('#ModuleMenuselections').attr('disabled', 'disabled');
		}
		if (menus == 2) {
			$('#ModuleMenuselections').removeAttr('disabled');
			$('#ModuleMenuselections').find('option').each(function() {
				$(this).attr('selected', false);
			});
		}
	});
	$('.htmlfile').change(function(e){
		var _use = $(this).val();
		if (_use == 'html') {
			$('.xtra').fadeOut('slow').promise().done(function(){ $('.usehtml').fadeIn('slow'); });
		}
		if (_use == 'file') {
			$('.xtra').fadeOut('slow').promise().done(function(){ $('.usefile').fadeIn('slow'); });
		}
		if (_use == 'menu') {
			$('.xtra').fadeOut('slow').promise().done(function(){ $('.usemenu').fadeIn('slow'); });
		}
	});
});
", array('inline' => false));?>