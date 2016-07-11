<?php $this->Html->pageClass = 'quotes';?>
<?php $this->Html->pageTitle = __('Edit Quote');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Edit Quote'));?>
<?php echo $this->Html->css(array('datatables', 'plugins/select2.min.css'), array('inline' => false));?>
<?php echo $this->start('heading');?>
<div class="options">
    <div class="btn-toolbar">
        <?php echo $this->Html->link('<i class="fa fa-file-pdf-o"></i> ' . __('Download PDF'), array('controller' => 'quotes', 'action' => 'export', $this->data['Quote']['id'], 'type' => 'pdf'), array('class' => 'btn btn-default', 'escape' => false));?>
        <?php echo $this->Html->link('<i class="fa fa-envelope-o"></i> ' . __('Email Quote'), array('controller' => 'quotes', 'action' => 'send', $this->data['Quote']['id'], 'type' => 'pdf'), array('class' => 'btn btn-inverse btn-emailquote', 'escape' => false));?>
    </div>
</div>
<?php echo $this->end();?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-green">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Edit Quote', true);?></h4>
				
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
                        <?php echo $this->Form->input('contact_name', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Name')), 'between' => '<div class="col-md-10 col-lg-8">', 'after' => '</div>', 'div' => 'form-group'));?>
                        <?php echo $this->Form->input('contact_address', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Address')), 'between' => '<div class="col-md-10 col-lg-8">', 'after' => '</div>', 'div' => 'form-group'));?>
                		<?php echo $this->Form->input('contact_phone', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Phone')), 'between' => '<div class="col-md-10 col-lg-8">', 'after' => '</div>', 'div' => 'form-group'));?>
                		<?php echo $this->Form->input('contact_email', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Email')), 'between' => '<div class="col-md-10 col-lg-8">', 'after' => '</div>', 'div' => 'form-group'));?>
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
		</div>
	</div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-green">
            <div class="panel-heading">
                <h4><i class="fa fa-list"></i> <?php echo __('Quote Items', true);?></h4>
                <div class="options">
                    <a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
                    <?php echo $this->Html->link('<i class="fa fa-plus"></i> ' . __('Add Item'), array('controller' => 'quote_items', 'action' => 'add', 'quote_id' => $this->data['Quote']['id']), array('class' => 'add-quoteitem', 'escape' => false));?>
                </div>
            </div>
            <div class="panel-body quoteitems">
                <?php if(isset($this->data['QuoteItem']) && !empty($this->data['QuoteItem'])) { ?>
                <?php $quotetotal = 0; ?>
                <?php foreach ($this->data['QuoteItem'] as $j) { ?>
                <div id="quoteitem-<?php echo $j['id'];?>" class="row quoteitem">
                    <div class="col-xs-12 col-md-9">
                        <?php echo $this->Form->input('QuoteItem.'.$j['id'].'.description', array('class' => 'form-control', 'label' => array('class' => 'col-sm-12 col-md-2 col-lg-1 control-label', 'text' => __('Description')), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'div' => 'form-group', 'value' => $j['description']));?>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <?php echo $this->Form->input('QuoteItem.'.$j['id'].'.amount', array('class' => 'form-control', 'label' => array('class' => 'col-sm-12 col-md-12 col-lg-3 control-label', 'text' => __('Amount')), 'between' => '<div class="col-md-10 col-lg-6">', 'after' => '</div>', 'div' => 'form-group', 'data-inputmask' => "'mask':'$ 999,999.99', 'greedy' : false, 'rightAlignNumerics' : false", 'type' => 'text', 'value' => $j['amount']));?>
                    </div>
                    <?php echo $this->Html->link('<i class="fa fa-trash"></i>', array('controller' => 'quote_items', 'action' => 'delete', $j['id']), array('class' => 'quoteitem-delete', 'data-quoteitem' => 'quoteitem-'.$j['id'], 'escape' => false));?>
                    <?php echo $this->Form->hidden('QuoteItem.'.$j['id'].'.id', array('value' => $j['id']));?>
                    <?php echo $this->Form->hidden('QuoteItem.'.$j['id'].'.quote_id', array('value' => $j['quote_id']));?>
                </div>
                <hr/>
                <?php } ?>
                <div class="row quotetotal">
                    <div class="col-xs-12 col-md-4 col-lg-3 col-md-offset-7 col-lg-offset-8">
                        <span class="col-md-7 col-lg-5 control-label"><?php echo __('Sub Total');?></span>
                        <span class="col-md-5"><?php echo $this->Number->currency($this->data['Quote']['subtotal'], 'AUD');?></span>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-3 col-md-offset-7 col-lg-offset-8">
                        <span class="col-md-7 col-lg-5 control-label"><?php echo __('Tax');?></span>
                        <span class="col-md-5"><?php echo $this->Number->currency($this->data['Quote']['tax_amt'], 'AUD');?></span>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-3 col-md-offset-7 col-lg-offset-8">
                        <span class="col-md-7 col-lg-5 control-label"><?php echo __('Total');?></span>
                        <span class="col-md-5"><?php echo $this->Number->currency($this->data['Quote']['total'], 'AUD');?></span>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-green">
            <div class="panel-heading">
                <h4><i class="fa fa-pencil"></i> <?php echo __('Quote Notes', true);?></h4>
                <div class="options">
                    <a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
                </div>
            </div>
            <div class="panel-body">  
				<div class="row">              
                <?php echo $this->Form->input('notes', array('class' => 'form-control wysiwyg', 'label' => array('class' => 'col-md-2 col-lg-1 control-label', 'text' => __('Customer Notes')), 'between' => '<div class="col-md-10">', 'after' => '<div class="help-block">'.__('This information is displayed at the bottom of the quote').'</div></div>', 'div' => 'form-group'));?>
				</div>
            </div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-6 col-md-offset-2 col-lg-offset-1">
						<div class="btn-toolbar">
							<?php echo $this->Form->submit('Save', array('class'=>'btn btn-primary', 'div' => false)); ?>
							<?php echo $this->Html->link('Cancel', array('controller' => 'quotes', 'action' => 'cancel', 'plugin' => false), array('class' => 'btn btn-default')); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="btn-toolbar">
							<?php if(!empty($this->data['Quote']['id'])){ ?>
								<?php echo $this->Form->hidden('id');?>
								<?php echo $this->Html->link('Delete', array('controller' => 'quotes', 'action' => 'delete', 'plugin' => false, $this->data['Quote']['id']), array('class' => 'btn btn-danger pull-right')); ?>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
<?php echo $this->Form->end();?>
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
<div id="addQuoteItem" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo __('Add Quote Item');?></h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <?php echo $this->Form->button(__('Close'), array('class' => 'btn btn-default', 'data-dismiss' => 'modal'));?>
        <?php echo $this->Form->button(__('Save'), array('class' => 'btn btn-primary', 'id' => 'saveQuoteItem'));?>
      </div>
    </div>
  </div>
</div>
<div id="emailQuote" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo __('Email Quote');?></h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
            <?php echo $this->Form->input('emailto', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Send To')), 'between' => '<div class="col-md-10 col-lg-8">', 'after' => '</div>', 'div' => 'form-group'));?>
            <?php echo $this->Form->input('subject', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Send To')), 'between' => '<div class="col-md-10 col-lg-8">', 'after' => '</div>', 'div' => 'form-group'));?>
            <?php echo $this->Form->input('message', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Message')), 'between' => '<div class="col-md-10 col-lg-8">', 'after' => '</div>', 'div' => 'form-group', 'type' => 'textarea'));?>
        </div>
      </div>
      <div class="modal-footer">
        <?php echo $this->Form->button(__('Send'), array('class' => 'btn btn-primary pull-left', 'id' => 'sendQuote'));?>
        <?php echo $this->Form->button(__('Close'), array('class' => 'btn btn-default pull-right', 'data-dismiss' => 'modal'));?>
      </div>
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
var quoteitems = function () {
    $('.quoteitem-delete').click(function(e){
        e.preventDefault();
        var _id = $(this).data('quoteitem');
        $.getJSON($(this).attr('href'), function(d){
            if (d.success) {
                $('#'+_id).fadeOut('slow' ,function(){ $(this).remove(); });
            }
            if (d.error) {
                alert(d.error);
            }
        });
    });
    $('#saveQuoteItem').click(function(e){
        e.preventDefault();
        $.post($('#QuoteItemAddForm').attr('action'), $('#QuoteItemAddForm').serialize(), function(d){
            if (d) {
                $('#addQuoteItem').modal('hide');
                $('.quoteitems').load(document.URL+' .quoteitems >');
            } else {
                alert('error');
            }
        });
    });
}
var emailquote = function() {
    $('.btn-emailquote').click(function(e){
        e.preventDefault();
        // clear form values
        $('#message').val('');$('#emailto').val(''); $('#subject').val('".__('Quote from') . ' ' . $this->Session->read('Auth.User.Client.name')."');
        // fill basics
        $('#emailto').val($('#QuoteContactEmail').val());
        $('#emailQuote').modal();
    });
    $('#sendQuote').click(function(e){
        e.preventDefault();
        $.post($('.btn-emailquote').attr('href'), { 'emailto': $('#emailto').val(), 'message': $('#message').val(), 'subject': $('#subject').val()}, function(d){
            if (d.success) {
                $('#emailQuote').modal('hide');
            } else {
                alert(d.message);
            }
        }, 'json');
    });
}
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
        $.post($('#QuoteEditForm').attr('action'), $('#QuoteEditForm').serialize(), function(d){
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

    $('.add-quoteitem').click(function(e){
        e.preventDefault();
        $('#addQuoteItem .modal-body').load($(this).attr('href')+' form');
        $('#addQuoteItem').modal();
    });
    quoteitems();
    emailquote();
    $('.select2').select2();

});", array('inline' => false));?>