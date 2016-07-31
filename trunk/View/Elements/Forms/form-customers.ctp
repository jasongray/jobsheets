<?php echo $this->Form->input('name', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Customer Name')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
<?php echo $this->Form->input('property', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Property Name')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
<?php echo $this->Form->input('unit', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Unit Number')), 'between' => '<div class="col-md-2">', 'after' => '</div>', 'div' => 'form-group'));?>
<div class="form-group">
	<?php echo $this->Form->input('address_from', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 col-xs-2 control-label', 'text' => __('From')), 'between' => '<div class="col-md-2 col-xs-4">', 'after' => '</div>', 'div' => false));?>
	<?php echo $this->Form->input('address_to', array('class' => 'form-control', 'label' => array('class' => 'col-md-1 col-xs-2 control-label', 'text' => __('To')), 'between' => '<div class="col-md-2 col-xs-4">', 'after' => '</div>', 'div' => false));?>
</div>
<?php echo $this->Form->input('address_street', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Street')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
<?php echo $this->Form->input('suburb', array('class' => 'form-control typeahead', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Suburb / Postcode')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group', 'data-provide' => 'typeahead', 'data-url' => $this->Html->url(array('controller' => 'postcodes', 'action' => 'get')), 'autocomplete' => 'off'));?>
<?php echo $this->Form->input('postcode_id', array('class' => 'form-control hidden', 'label' => false));?>				

<?php echo $this->start('panel-footer');?>
<div class="panel-footer">
	<div class="row">
		<div class="col-md-5 col-md-offset-2">
			<div class="btn-toolbar">
				<?php echo $this->Form->submit('Save', array('class'=>'btn btn-primary', 'div' => false)); ?>
				<?php echo $this->Html->link('Cancel', array('controller' => 'customers', 'action' => 'cancel', 'plugin' => false), array('class' => 'btn btn-default')); ?>
			</div>
		</div>
		<div class="col-md-5">
			<div class="btn-toolbar">
				<?php if(!empty($this->data['Customer']['id'])){ ?>
					<?php echo $this->Form->hidden('id');?>
					<?php echo $this->Html->link('Delete', array('controller' => 'customers', 'action' => 'delete', 'plugin' => false, $this->data['Customer']['id'], ), array('class' => 'btn btn-danger pull-right')); ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->end();?>

<?php echo $this->element('Forms/form-javascript');?>
<?php echo $this->Html->script(array('plugins/bootstrap-typeahead/bootstrap-typeahead.min'), array('inline' => false));?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function() {

	$('#CustomerSuburb.typeahead').typeahead({
        onSelect: function(item) {
            $('#CustomerPostcodeId').val(item.value);
        },
        displayField: 'suburb',
        ajax: {
            url: '".$this->Html->url(array('controller' => 'postcodes', 'action' => 'get'))."',
            method: 'POST',
            preDispatch: function (query) {
                return {
                    search: query
                }
            },
            preProcess: function (data) {
                if (data.success === false) {
                    return false;
                }
                return data;
            }
        },
    });
    
});", array('inline' => false));?>