<?php echo $this->Form->input('name', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Customer Name')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
<hr/>
<?php echo $this->Form->input('property', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Property Name')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
<?php echo $this->Form->input('unit', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Unit Number')), 'between' => '<div class="col-md-2">', 'after' => '</div>', 'div' => 'form-group'));?>
<div class="form-group">
	<?php echo $this->Form->input('address_from', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 col-xs-2 control-label', 'text' => __('From')), 'between' => '<div class="col-md-2 col-xs-4">', 'after' => '</div>', 'div' => false));?>
	<?php echo $this->Form->input('address_to', array('class' => 'form-control', 'label' => array('class' => 'col-md-1 col-xs-2 control-label', 'text' => __('To')), 'between' => '<div class="col-md-2 col-xs-4">', 'after' => '</div>', 'div' => false));?>
</div>
<?php echo $this->Form->input('address_street', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Street')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
<?php echo $this->Form->input('suburb', array('class' => 'form-control typeahead', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Suburb / Postcode')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group', 'data-provide' => 'typeahead', 'data-url' => $this->Html->url(array('controller' => 'postcodes', 'action' => 'get')), 'autocomplete' => 'off'));?>
<?php echo $this->Form->hidden('postcode_id');?>				
<div class="form-actions">
<?php
	echo $this->Form->hidden('id');
	echo $this->Form->submit('Save', array('class'=>'btn btn-primary', 'div' => false)); 
	echo $this->Html->link('Cancel', array('controller' => 'customers', 'action' => 'cancel', 'plugin' => false), array('class' => 'btn btn-grey'));
	if(!empty($this->data['Customer']['id'])){
		echo $this->Html->link('Delete', array('controller' => 'customers', 'action' => 'delete', 'plugin' => false, $this->data['Customer']['id']), array('class' => 'btn btn-grey'));
	}
?>	
</div>
<?php echo $this->element('Forms/form-javascript');?>