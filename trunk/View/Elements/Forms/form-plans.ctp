<?php echo $this->Form->input('name', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Name'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('description', array('div' => 'form-group', 'class' => 'form-control wysiwyg', 'label' => array('text' => __('Description'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('userlimit', array('div' => 'form-group wysiwyg', 'class' => 'form-control', 'label' => array('text' => __('User Limit'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('type', array('div' => 'form-group wysiwyg', 'class' => 'form-control', 'label' => array('text' => __('Type'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('billing', array('div' => 'form-group wysiwyg', 'class' => 'form-control', 'label' => array('text' => __('Billing Amt'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('period', array('div' => 'form-group wysiwyg', 'class' => 'form-control', 'label' => array('text' => __('Frequency'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'options' => array(1 => __('Monthly'), 2 => __('BiMonthly'), 4 => __('Quarterly'), 12 => __('Annually')))); ?>
<?php echo $this->Form->input('active', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Status'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'empty' => '', 'options' => array(0 => 'Retired', 1 => 'Active'))); ?>
<?php echo $this->start('panel-footer');?>
<div class="panel-footer">
	<div class="row">
		<div class="col-md-5 col-md-offset-2">
			<div class="btn-toolbar">
				<?php echo $this->Form->submit('Save', array('class'=>'btn btn-primary', 'div' => false)); ?>
				<?php echo $this->Html->link('Cancel', array('controller' => 'plans', 'action' => 'cancel', 'plugin' => false), array('class' => 'btn btn-default')); ?>
			</div>
		</div>
		<div class="col-md-5">
			<div class="btn-toolbar">
				<?php if(!empty($this->data['Plan']['id'])){ ?>
					<?php echo $this->Form->hidden('id');?>
					<?php echo $this->Html->link('Delete', array('controller' => 'plans', 'action' => 'delete', 'plugin' => false, $this->data['Plan']['id']), array('class' => 'btn btn-danger pull-right')); ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->end();?>

<?php echo $this->Html->script(array(
'plugins/bootstrap-typeahead/bootstrap-typeahead.min', 
'plugins/select2/select2.min.js',
'plugins/tinymce/tinymce.min',
'plugins/tinymce/jquery.tinymce.min',
), array('inline' => false));?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function() {
	
    $('textarea.wysiwyg').tinymce({
        plugins: [
            \"advlist autolink lists link image charmap print preview anchor\",
            \"searchreplace visualblocks code fullscreen textcolor colorpicker textpattern\",
            \"insertdatetime media table contextmenu paste moxiemanager\"
        ],
        toolbar1: \"undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent\",
        toolbar2: \"link image insertfile media | forecolor textpattern code\",
        relative_urls: false,
        remove_script_host: false,
        schema: 'html5',
        extended_valid_elements : 'i[class],script[type]',
    });

    $('.select2').select2();

});", array('inline' => false));?>