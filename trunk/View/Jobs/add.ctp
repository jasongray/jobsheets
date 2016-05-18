<?php $this->Html->pageClass = 'jobs';?>
<?php $this->Html->pageTitle = __('Create a Job');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Create Job'));?>
<?php echo $this->Html->css(array('datatables'), array('inline' => false));?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Create Job', true);?></h4>
				
			</div>
			<div class="panel-body">
				<?php echo $this->Form->create('Job', array('class' => 'wizard form-horizontal', 'novalidate' => true));?>
				<fieldset title="<?php echo __('Step 1');?>">
					<legend><?php echo __('Location');?></legend>
					<?php echo $this->Form->input('property', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Property Name')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
					<?php echo $this->Form->input('unit', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Unit Number')), 'between' => '<div class="col-md-2">', 'after' => '</div>', 'div' => 'form-group'));?>
					<div class="form-group">
						<?php echo $this->Form->input('address_from', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 col-xs-2 control-label', 'text' => __('From')), 'between' => '<div class="col-md-2 col-xs-4">', 'after' => '</div>', 'div' => false));?>
						<?php echo $this->Form->input('address_to', array('class' => 'form-control', 'label' => array('class' => 'col-md-1 col-xs-2 control-label', 'text' => __('To')), 'between' => '<div class="col-md-2 col-xs-4">', 'after' => '</div>', 'div' => false));?>
					</div>
					<?php echo $this->Form->input('address_street', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Street')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group', 'required' => false));?>
					<?php echo $this->Form->input('suburb', array('class' => 'form-control typeahead', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Suburb / Postcode')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group', 'data-provide' => 'typeahead', 'data-url' => $this->Html->url(array('controller' => 'postcodes', 'action' => 'get')), 'autocomplete' => 'off'));?>
                        <?php echo $this->Form->hidden('postcode_id');?>
                     <hr/>
                     <h4><?php echo __('Or...');?></h4>
                     <?php echo $this->Form->input('customer', array('class' => 'form-control typeahead', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Select Customer')), 'between' => '<div class="input-group col-md-6">', 'after' => '<span class="input-group-btn">'.$this->Html->link('<i class="fa fa-plus"></i>', array('controller' => 'customers', 'action' => 'add'), array('class' => 'btn btn-info add-customer', 'title' => __('Quick Add Customer'), 'escape' => false)).'</span></div>', 'div' => 'form-group', 'data-provide' => 'typeahead', 'data-url' => $this->Html->url(array('controller' => 'customers', 'action' => 'get')), 'autocomplete' => 'off', 'type' => 'text'));?>
                        <?php echo $this->Form->hidden('customer_id');?>
				</fieldset>
				<fieldset title="<?php echo __('Step 2');?>">
					<legend><?php echo __('Job Details');?></legend>
					<?php echo $this->Form->input('reference', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Client Reference')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
					<?php echo $this->Form->input('title', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Job Title')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
				</fieldset>
				<?php echo $this->Form->submit(__('Next'), array('class' => 'stepy-finish btn btn-success', 'div' => false));?>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
</div>
<div id="addModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo __('Add Customer');?></h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <?php echo $this->Form->button(__('Close'), array('class' => 'btn btn-default', 'data-dismiss' => 'modal'));?>
        <?php echo $this->Form->button(__('Save'), array('class' => 'btn btn-primary', 'id' => 'saveModal'));?>
      </div>
    </div>
  </div>
</div>
<?php echo $this->Html->script(array('plugins/validation/jquery.validate.min', 'plugins/stepy/jquery.stepy', 'plugins/bootstrap-typeahead/bootstrap-typeahead.min'), array('inline' => false));?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function() {

    $('.wizard').stepy({finishButton: true, titleClick: true, block: true, validate: true});

    //Add Wizard Compability - see docs
    $('.stepy-navigator').wrapInner('<div class=\"pull-right\"></div>');

    //Make Validation Compability - see docs
    $('.wizard').validate({
        errorClass: \"help-block\",
        validClass: \"help-block\",
        highlight: function(element, errorClass,validClass) {
           $(element).closest('.form-group').addClass(\"has-error\");
        },
        unhighlight: function(element, errorClass,validClass) {
            $(element).closest('.form-group').removeClass(\"has-error\");
        }
     });

	$('#JobSuburb.typeahead').typeahead({
        onSelect: function(item) {
            $('#JobPostcodeId').val(item.value);
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

	$('#JobCustomer.typeahead').typeahead({
        onSelect: function(item) {
            $('#JobCustomerId').val(item.value);
        },
        displayField: 'customer',
        ajax: {
            url: '".$this->Html->url(array('controller' => 'customers', 'action' => 'get'))."',
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

    $('.add-customer').click(function(e){
        e.preventDefault();
        $('#addModal .modal-body').load($(this).attr('href')+' form', function(){ 
            $('.modal-body .btn').remove(); 
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
        });
        $('#addModal').modal();
    });

    $('#saveModal').click(function(e){
        e.preventDefault();
        $.post($('#CustomerAddForm').attr('action'), $('#CustomerAddForm').serialize(), function(d){
            if (d.code == 200) {
                $('#addModal').modal('hide');
                $('#JobCustomerId').val(d.data.Customer.id);
                $('#JobCustomer').val(d.data.Customer.name);
            } else {
                alert(d.message);
            }
        }, 'json');
    });
    
});", array('inline' => false));?>