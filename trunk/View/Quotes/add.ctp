<?php $this->Html->pageClass = 'quotes';?>
<?php $this->Html->pageTitle = __('Create Quote');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Create Quote'));?>
<?php echo $this->Html->css(array('datatables', 'plugins/select2.min.css'), array('inline' => false));?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-green">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Create Quote', true);?></h4>
				
			</div>
			<div class="panel-body">
				<?php echo $this->Form->create('Quote', array('class' => 'form-horizontal', 'novalidate' => true));?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $this->Form->input('title', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 col-lg-1 control-label', 'text' => __('Subject')), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'div' => 'form-group'));?>
                        <hr/>
                    </div>
                </div>
				<div class="row">
					<div class="col-md-12 col-lg-6">
						<?php echo $this->Form->input('customer', array('class' => 'form-control select2-customer', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Select Customer')), 'between' => '<div class="col-md-8"><div class="input-group">', 'after' => '<div class="input-group-btn"><span class="input-group-btn">'.$this->Html->link('<i class="fa fa-plus"></i>', array('controller' => 'customers', 'action' => 'add'), array('class' => 'btn btn-info add-customer', 'title' => __('Add New Customer'), 'escape' => false)).'</span></div></div></div>', 'div' => 'form-group', 'data-provide' => 'typeahead', 'data-url' => $this->Html->url(array('controller' => 'customers', 'action' => 'get')), 'autocomplete' => 'off', 'type' => 'select', 'empty' => ''));?>
                        <?php echo $this->Form->hidden('customer_id');?>
                        <?php echo $this->Form->input('name', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Name')), 'between' => '<div class="col-md-10 col-lg-8">', 'after' => '</div>', 'div' => 'form-group'));?>
                        <?php echo $this->Form->input('address', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Address')), 'between' => '<div class="col-md-10 col-lg-8">', 'after' => '</div>', 'div' => 'form-group'));?>
                		<?php echo $this->Form->input('phone', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Phone')), 'between' => '<div class="col-md-10 col-lg-8">', 'after' => '</div>', 'div' => 'form-group'));?>
                		<?php echo $this->Form->input('email', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Email')), 'between' => '<div class="col-md-10 col-lg-8">', 'after' => '</div>', 'div' => 'form-group'));?>
                	</div>
                	<div class="col-md-12 col-lg-5 col-lg-offset-1">
                		<?php $_date = (empty($this->data['Quote']['date']))? date('Y-m-d'): $this->data['Quote']['date'];?>
                		<?php echo $this->Form->input('date', array('div' => 'form-group', 'id' => 'quotedate', 'class' => 'form-control', 'label' => array('text' => __('Quote Date'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10"><div class="input-group">', 'after' => '<span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div>', 'type' => 'text', 'value' => $_date));?>
                		<?php $_expires = (empty($this->data['Quote']['date']))? date('Y-m-d', strtotime('+30 days')): $this->data['Quote']['expires'];?>
                		<?php echo $this->Form->input('expires', array('div' => 'form-group', 'id' => 'quoteexpiry', 'class' => 'form-control', 'label' => array('text' => __('Expiry Date'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10"><div class="input-group">', 'after' => '<span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div>', 'type' => 'text', 'value' => $_expires));?>
                		<?php echo $this->Form->input('status', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Status')), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'div' => 'form-group', 'empty' => '', 'options' => array(__('Draft'), __('Emailed'), __('
                		Accepted'), 8 => __('Completed'), 9 => __('Cancelled'))));?>
                        <?php echo $this->Form->input('tax_id', array('class' => 'form-control select2', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Tax')), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'div' => 'form-group', 'empty' => ''));?>
                	</div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr/>
                        <?php echo $this->Form->input('quotenotes', array('class' => 'form-control wysiwyg', 'label' => array('class' => 'col-md-2 col-lg-1 control-label', 'text' => __('Proposal Text')), 'between' => '<div class="col-md-10">', 'after' => '<div class="help-block">'.__('This information is displayed at the top of the quote').'</div></div>', 'div' => 'form-group'));?>
                        <hr/>
                    </div>
                </div>
			</div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-1">
                        <div class="btn-toolbar">
                            <?php echo $this->Form->submit(__('Create Quote'), array('div' => false, 'class' => 'btn-primary btn'));?>
                            <?php echo $this->Html->link(__('Cancel'), array('action' => 'cancel'), array('class' => 'btn-default btn'));?>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $this->Form->end();?>
		</div>
	</div>
</div>
<?php echo $this->Html->script(array(
'plugins/bootstrap-datepicker/bootstrap-datepicker', 
'plugins/bootstrap-typeahead/bootstrap-typeahead.min', 
'plugins/select2/select2.min.js',
'plugins/tinymce/tinymce.min',
'plugins/tinymce/jquery.tinymce.min',
), array('inline' => false));?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function() {

	$('#QuoteCustomer.select2-customer').select2({
        minimumInputLength: 3,
        ajax: {
        	url: '".$this->Html->url(array('controller' => 'customers', 'action' => 'get'))."',
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                var query = { search: params.term }
                return query;
            },
            processResults: function (data, params) {
                return { results: data }
            },
        },
	})
    $('#QuoteCustomer.select2-customer').on('select2:select', function(e){
        $('#QuoteCustomerId').val(e.params.data.id);
        $('#QuoteName').val(e.params.data.params.contact);
        $('#QuoteAddress').val(e.params.data.params.address);
        $('#QuotePhone').val(e.params.data.params.phone);
        $('#QuoteEmail').val(e.params.data.params.email);
    });
    $('#QuoteCustomer.select2-customer').on('select2:unselect', function(e){
        $('#QuoteCustomerId').val('');
        $('#QuoteName').val('');
        $('#QuoteAddress').val('');
        $('#QuotePhone').val('');
        $('#QuoteEmail').val('');
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
                $('#QuoteCustomerId').val(d.data.Customer.id);
                $('#QuoteCustomer').val(d.data.Customer.name);
            } else {
                alert(d.message);
            }
        }, 'json');
    });

	$('#quotedate').datepicker({
		format: 'yyyy-mm-dd',
		startDate: 'today',
	});
	$('#quoteexpiry').datepicker({
		format: 'yyyy-mm-dd',
		startDate: '+30d',
	});

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

});", array('inline' => false));?>