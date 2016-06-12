<?php echo $this->Form->input('title', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Title'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<?php echo $this->Form->input('iclass', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Icon'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10"><div class="input-group">', 'after' => '<span class="input-group-addon"><a href="#iconModal" role="button" data-toggle="modal"><i class="fa fa-question-sign"></i></a></span></div></div>')); ?>
<?php echo $this->Form->input('class', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Item Class'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Publish');?></label>
	<div class="col-md-10">
		<?php echo $this->Form->input('published', array('div' => false, 'label' => array('text' => '', 'class' => 'checkbox'), 'class' => 'uniform', 'type' => 'checkbox')); ?>
	</div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Homepage Link');?></label>
	<div class="col-md-10">
		<?php echo $this->Form->input('default', array('div' => false, 'label' => array('text' => '', 'class' => 'checkbox'), 'class' => 'uniform', 'type' => 'checkbox')); ?>
	</div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label"><?php echo __('Divider');?></label>
	<div class="col-md-10">
		<?php echo $this->Form->input('divider', array('div' => false, 'label' => array('text' => '', 'class' => 'checkbox'), 'class' => 'uniform', 'type' => 'checkbox')); ?>
	</div>
</div>
<?php echo $this->Form->input('parent_id', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Parent Item'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'options' => $parents, 'empty' => '')); ?>
<?php echo $this->Form->input('menu_id', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Menu selection'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'options' => $menus, 'selected' => $this->passedArgs['menu_id'], 'empty' => '')); ?>
<?php echo $this->Form->input('permissions', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Select Group'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '<span class="help-block align-right">'.__('Select the lowest group who can access this menu item. Leave blank for all user levels.').'</span></div>', 'options' => $_groups, 'data-placeholder' => __('Lowest group who can access this menu item?'), 'empty' => ''));?>
<div class="panel-footer">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('class'=>'btn btn-primary', 'div' => false)); 
	echo $this->Html->link('Cancel', array('controller' => 'menuItems', 'action' => 'cancel', 'plugin' => false, 'menu_id' => $this->passedArgs['menu_id']), array('class' => 'btn btn-default'));
	if(!empty($this->data['MenuItem']['id'])){
		echo $this->Html->link('Delete', array('controller' => 'menuItems', 'action' => 'delete', 'plugin' => false, $this->data['MenuItem']['id'], 'menu_id' => $this->passedArgs['menu_id']), array('class' => 'btn btn-danger'));
	}
?>	
</div>
<?php echo $this->element('Forms/form-javascript');?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function(){
	$('#MenuItemController').change(function(){
		var method = $(this).val();
		if(method!=''){
			$.ajax({
				type:'GET',
				cache:false,
				url:_baseurl+'menuItems/getViews/method:'+method,
				success:function(html){
					$('#MenuItemAction').html(html);
				}
			});
		}
		if(method == 'news'){
			$('.extras').slideToggle();
		} else {
			$('.extras').slideUp();
		}
		if(method == 'contact'){
			$('.contact').slideToggle();
		} else {
			$('.contact').slideUp();
		}
		if(method == 'categories'){
			$('.categories').slideToggle();
		} else {
			$('.categories').slideUp();
		}
		return false;
	});
});
" , array('inline' => false));?>
	
