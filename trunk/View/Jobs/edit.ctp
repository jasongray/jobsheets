<?php $this->Html->pageClass = 'jobs';?>
<?php $this->Blocks->set('title', __('Edit Job ' . $this->data['Job']['id']));?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Job List'), array('controller' => 'jobs', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Edit Job ') . $this->data['Job']['id']);?>
<?php echo $this->Html->css(array('datatables', 'plugins/jquery-ui', 'plugins/timepicker', 'plugins/signature-pad'), array('block' => 'css'));?>
<?php echo $this->start('heading');?>
<?php if ($this->data['Job']['status'] > 7) { ?>
<div class="options">
    <div class="btn-toolbar">
        <?php echo $this->Html->link('<i class="fa fa-history"></i> '.__('Reallocate'), array('action' => 'reallocate', $this->data['Job']['id']), array('class' => 'btn btn-primary btn-label', 'escape' => false));?>
        <?php if (empty($this->data['Job']['invoice_date']) && empty($this->data['Job']['invoice_id'])) { ?>
        <?php echo $this->Html->link('<i class="fa fa-sign-out"></i> '.__('Create Invoice'), array('action' => 'invoice', $this->data['Job']['id']), array('class' => 'btn btn-default btn-label', 'escape' => false));?>
        <?php } else { ?>
        <div class="form-group">
            <span class="col-md-2 control-label"><?php echo __('Invoice');?></span>
            <div class="col-md-6">
                <?php echo $this->Html->link($this->data['Job']['invoice_id'], array('controller' => 'invoices', 'action' => 'view', $this->data['Job']['invoice_id']));?><span class="help-text"><?php echo __('Created');?> :: <?php echo date('d M Y', strtotime($this->data['Job']['invoice_date']));?></span>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>
<?php echo $this->end();?>
<div class="row">
    <?php echo $this->Form->create('Job', array('class' => 'wizard form-horizontal'));?>
	<div class="col-xs-12">
		<div class="panel panel-orange">
			<div class="panel-heading">
				<h4><i class="fa fa-cogs"></i> <?php echo __('Edit Job', true);?></h4>
                <div class="options">
                    <a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
                </div>
			</div>
			<div class="panel-body">
                <legend><?php echo __(sprintf('J%s', $this->data['Job']['id']));?></legend>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->input('title', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Job Title')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
        				<?php echo $this->Form->input('reference', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Client Reference')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
                        <?php echo $this->Form->input('customer', array('class' => 'form-control typeahead', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Customer')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group', 'data-provide' => 'typeahead', 'data-url' => $this->Html->url(array('controller' => 'customers', 'action' => 'get')), 'autocomplete' => 'off', 'type' => 'text'));?>
                        <?php echo $this->Form->hidden('customer_id');?>
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
                        <?php echo $this->Form->input('contact_name', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Contact')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
                        <?php echo $this->Form->input('contact_phone', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Phone')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
                        <?php echo $this->Form->input('contact_email', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Email')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->input('user_id', array('class' => 'form-control', 'label' => array('class' => 'col-md-3 control-label', 'text' => __('Allocate Job to')), 'between' => '<div class="col-md-7">', 'after' => '</div>', 'div' => 'form-group', 'multiple'));?>
                        <?php echo $this->Form->input('allocated', array('div' => 'form-group', 'class' => 'form-control datetimepicker', 'label' => array('text' => __('Allocated date'), 'class' => 'col-md-3 control-label'), 'between' => '<div class="col-md-7"><div class="input-group date">', 'after' => '<span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div>', 'type' => 'text'));?>
                        <?php echo $this->Form->input('dueby', array('div' => 'form-group', 'class' => 'form-control datetimepicker', 'label' => array('text' => __('Due by date'), 'class' => 'col-md-3 control-label'), 'between' => '<div class="col-md-7"><div class="input-group date">', 'after' => '<span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div>', 'type' => 'text'));?>
                        <?php echo $this->Form->input('notes', array('class' => 'form-control', 'label' => array('class' => 'col-md-3 control-label', 'text' => __('Job Notes')), 'between' => '<div class="col-md-7">', 'after' => '</div>', 'div' => 'form-group', 'rows' => 8));?>
                        <?php echo $this->Form->input('status', array('class' => 'form-control', 'label' => array('class' => 'col-md-3 control-label', 'text' => __('Job Status')), 'between' => '<div class="col-md-7">', 'after' => '</div>', 'div' => 'form-group', 'empty' => '', 'options' => array(__('Unallocated'), __('Allocated'), __('Tasked'), __('Draft'), 8 => __('Completed'), 9 => __('Cancelled'))));?>
                        <hr/>
                        <?php if (!empty($this->data['Job']['signoff_sig'])) { ?>
                        <?php echo $this->Form->input('signoff_name', array('class' => 'form-control', 'label' => array('class' => 'col-md-3 control-label', 'text' => __('Name')), 'between' => '<div class="col-md-7">', 'after' => '</div>', 'div' => 'form-group'));?>  
                        <?php echo $this->Form->hidden('signoff_sig');?>
                        <div class="form-group">
                            <span class="col-md-3 control-label"><?php echo __('Signature');?></span>
                            <div class="col-md-7">
                                <span class="form-control sig-wrapper">
                                    <img src="<?php echo $this->data['Job']['signoff_sig'];?>" alt="" class="img-responsive"/>
                                </span>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $this->Form->input('description', array('class' => 'form-control', 'label' => array('class' => 'col-md-1 control-label', 'text' => __('Job Description')), 'between' => '<div class="col-md-11">', 'after' => '</div>', 'div' => 'form-group', 'type' => 'textarea', 'class' => 'form-control wysiwyg', 'rows' => 15));?>
                    </div>
				</div>
			</div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-1">
                        <div class="btn-toolbar">
                            <?php echo $this->Form->hidden('id');?>
                            <?php echo $this->Form->submit(__('Save'), array('div' => false, 'class' => 'btn-primary btn'));?>
                            <?php echo $this->Html->link(__('Cancel'), array('action' => 'cancel'), array('class' => 'btn-default btn'));?>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="btn-toolbar">
                            <?php echo $this->Html->link(__('Delete Job'), array('action' => 'delete', $this->data['Job']['id']), array('class' => 'btn-danger btn pull-right'));?>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
    <div class="col-xs-12">
        <div class="panel panel-orange">
            <div class="panel-heading">
                <h4><i class="fa fa-wrench"></i> <?php echo __('Job Items', true);?></h4>
                <div class="options">
                    <a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
                    <?php echo $this->Html->link('<i class="fa fa-plus"></i> ' . __('Add Job Item'), array('controller' => 'job_items', 'action' => 'add', 'job_id' => $this->data['Job']['id']), array('class' => 'add-jobitem', 'escape' => false));?>
                </div>
            </div>
            <div class="panel-body jobitems">
                <?php if($this->data['JobItem']){ ?>
                <?php foreach ($this->data['JobItem'] as $j) { ?>
                <div id="jobitem-<?php echo $j['id'];?>" class="row jobitem">
                    <div class="col-xs-12 col-md-8">
                        <?php echo $this->Form->input('JobItem.'.$j['id'].'.description', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Description')), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'div' => 'form-group', 'value' => $j['description']));?>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <?php echo $this->Form->input('JobItem.'.$j['id'].'.status', array('class' => 'form-control', 'label' => array('class' => 'col-md-3 control-label', 'text' => __('Status')), 'between' => '<div class="col-md-8">', 'after' => '</div>', 'div' => 'form-group', 'empty' => '', 'options' => array(__('Unallocated'), __('Allocated'), __('Tasked'), __('Draft'), 8 => __('Completed'), 9 => __('Cancelled')), 'selected' => $j['status']));?>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <?php echo $this->Form->input('JobItem.'.$j['id'].'.amount', array('class' => 'form-control', 'label' => array('class' => 'col-md-3 control-label', 'text' => __('Amount')), 'between' => '<div class="col-md-8">', 'after' => '</div>', 'div' => 'form-group', 'data-inputmask' => "'mask':'$ 999,999.99', 'greedy' : false, 'rightAlignNumerics' : false", 'type' => 'text', 'value' => $j['amount']));?>
                    </div>
                    <?php echo $this->Html->link('<i class="fa fa-trash"></i>', array('controller' => 'job_items', 'action' => 'delete', $j['id']), array('class' => 'jobitem-delete', 'data-jobitem' => 'jobitem-'.$j['id'], 'escape' => false));?>
                    <?php echo $this->Form->hidden('JobItem.'.$j['id'].'.id', array('value' => $j['id']));?>
                    <?php echo $this->Form->hidden('JobItem.'.$j['id'].'.job_id', array('value' => $j['job_id']));?>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php echo $this->Form->end();?>
</div>
<div id="addJobItem" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo __('Add Job Item');?></h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <?php echo $this->Form->button(__('Close'), array('class' => 'btn btn-default', 'data-dismiss' => 'modal'));?>
        <?php echo $this->Form->button(__('Save'), array('class' => 'btn btn-primary', 'id' => 'saveJobItem'));?>
      </div>
    </div>
  </div>
</div>
<?php echo $this->Html->script(array(
    'plugins/timepicker/timepicker.js', 
    'plugins/bootstrap-typeahead/bootstrap-typeahead.min',
    'plugins/tinymce/tinymce.min',
    'plugins/tinymce/jquery.tinymce.min',
), array('inline' => false));?>
<?php echo $this->Html->scriptBlock("
var jobitems = function () {
    $('.jobitem-delete').click(function(e){
        e.preventDefault();
        var _id = $(this).data('jobitem');
        $.getJSON($(this).attr('href'), function(d){
            if (d.success) {
                $('#'+_id).fadeOut('slow' ,function(){ $(this).remove(); });
            }
            if (d.error) {
                alert(d.error);
            }
        });
    });
    $('#saveJobItem').click(function(e){
        e.preventDefault();
        $.post($('#JobItemAddForm').attr('action'), $('#JobItemAddForm').serialize(), function(d){
            if (d) {
                $('#addJobItem').modal('hide');
                $('.jobitems').load(document.URL+' .jobitems >');
            } else {
                alert('error');
            }
        });
    });
}
$(document).ready(function(){

    if ($('.datetimepicker').length > 0) {
        $('.datetimepicker').datetimepicker({
            formatDate: 'Y-m-d', 
            formatTime: 'H:i',
            defaultDate: '".date('Y-m-d')."',
            defaultTime: '".date('H:i')."',
        });
    }

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

    $('textarea.wysiwyg').tinymce({
        plugins: [
            \"advlist autolink lists link image charmap print preview anchor\",
            \"searchreplace visualblocks code fullscreen textcolor colorpicker textpattern\",
            \"insertdatetime media table contextmenu paste moxiemanager\"
        ],
        toolbar1: \"undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent\",
        toolbar2: \"preview link image insertfile media | forecolor textpattern code\",
        relative_urls: false,
        remove_script_host: false,
        schema: 'html5',
        extended_valid_elements : 'i[class],script[type]',

    });

    $('.add-jobitem').click(function(e){
        e.preventDefault();
        $('#addJobItem .modal-body').load($(this).attr('href')+' form');
        $('#addJobItem').modal();
    });
    $('.add-client').click(function(e){
        e.preventDefault();
        $('#addJobItem .modal-body').load($(this).attr('href')+' form');
        $('#addJobItem').modal();
    });
    jobitems();
});
" , array('inline' => false));?>