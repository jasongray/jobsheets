<?php $this->Html->pageClass = 'jobs';?>
<?php $this->Blocks->set('title', __('View Job ' . $this->data['Job']['id']));?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Job List'), array('controller' => 'jobs', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('View Job ') . $this->data['Job']['id']);?>
<?php echo $this->Html->css(array('datatables', 'plugins/jquery-ui', 'plugins/timepicker', 'plugins/signature-pad'), array('block' => 'css'));?>
<div class="row">
    <?php echo $this->Form->create('Job', array('class' => 'wizard form-horizontal'));?>
	<div class="col-xs-12 col-sm-7">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-cogs"></i> <?php echo __('Job Details', true);?></h4>
                <div class="options">
                    <a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
                </div>
			</div>
			<div class="panel-body">
                <legend>
                    <?php echo __(sprintf('J%s', $this->data['Job']['id']));?>
                    <?php if(time() > strtotime($this->data['Job']['dueby'])) { ?>
                        <span class="badge badge-danger"><?php echo __('Overdue');?></span>
                    <?php } ?>
                </legend>
                <div class="form-group">
                    <span class="col-md-2 control-label"><?php echo __('Job Title');?></span>
                    <div class="col-md-6">
                        <span class="form-control"><?php echo $this->data['Job']['title'];?></span>
                    </div>
                </div>
                <div class="form-group">
                    <span class="col-md-2 control-label"><?php echo __('Client Reference');?></span>
                    <div class="col-md-6">
                        <span class="form-control"><?php echo $this->data['Job']['reference'];?></span>
                    </div>
                </div>
                <div class="form-group">
                    <span class="col-md-2 control-label"><strong><?php echo __('Due By');?></strong></span>
                    <div class="col-md-6">
                        <span class="label label-warning label-lg">
                            <?php echo date('l jS F Y', strtotime($this->data['Job']['dueby']));?>
                        </span>
                    </div>
                </div>
                <hr/>
                <div class="form-group">
                    <span class="col-md-2 control-label"><?php echo __('Customer');?></span>
                    <div class="col-md-6">
                        <span class="form-control"><?php echo $this->data['Job']['customer'];?></span>
                    </div>
                </div>
                <div class="form-group">
                    <span class="col-md-2 control-label"><?php echo __('Property Name');?></span>
                    <div class="col-md-6">
                        <span class="form-control"><?php echo $this->data['Job']['property'];?></span>
                    </div>
                </div>
                <div class="form-group">
                    <span class="col-md-2 control-label"><?php echo __('Unit Number');?></span>
                    <div class="col-md-2">
                        <span class="form-control"><?php echo $this->data['Job']['unit'];?></span>
                    </div>
                </div>
                <div class="form-group">
                    <span class="col-md-2 col-xs-2 control-label"><?php echo __('From');?></span>
                    <div class="col-md-2 col-xs-4">
                        <span class="form-control"><?php echo $this->data['Job']['address_from'];?></span>
                    </div>
                    <span class="col-md-1 col-xs-2 control-label"><?php echo __('To');?></span>
                    <div class="col-md-2 col-xs-4">
                        <span class="form-control"><?php echo $this->data['Job']['address_to'];?></span>
                    </div>
                </div>
                <div class="form-group">
                    <span class="col-md-2 control-label"><?php echo __('Street');?></span>
                    <div class="col-md-6">
                        <span class="form-control"><?php echo $this->data['Job']['address_street'];?></span>
                    </div>
                </div>
                <div class="form-group">
                    <span class="col-md-2 control-label"><?php echo __('Suburb / Postcode');?></span>
                    <div class="col-md-6">
                        <span class="form-control"><?php echo $this->data['Job']['suburb'];?></span>
                    </div>
                </div>
                <div class="form-group">
                    <span class="col-md-2 control-label"><?php echo __('Contact');?></span>
                    <div class="col-md-3">
                        <span class="form-control"><?php echo $this->data['Job']['contact_name'];?></span>
                    </div>
                    <span class="col-md-2 control-label"><?php echo __('Ph');?></span>
                    <div class="col-md-3">
                        <span class="form-control"><?php echo $this->data['Job']['contact_phone'];?></span>
                    </div>
                </div>
                <div class="form-group">
                    <span class="col-md-2 control-label"><?php echo __('Email');?></span>
                    <div class="col-md-6">
                        <span class="form-control"><?php echo $this->data['Job']['contact_email'];?></span>
                    </div>
                </div>
                <hr/>
                <div class="form-group">
                    <span class="col-md-2 control-label"><?php echo __('Job Description');?></span>
                    <div class="col-md-6">
                        <?php echo $this->data['Job']['description'];?>
                    </div>
                </div>
			</div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-2">
                        <div class="btn-toolbar">
                            <?php echo $this->Form->hidden('id');?>
                            <?php echo $this->Html->link(__('Close'), array('action' => 'cancel'), array('class' => 'btn-default btn btn-lg'));?>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
    <div class="col-xs-12 col-sm-5">
        <div class="panel panel-midnightblue">
            <div class="panel-heading">
                <h4><i class="fa fa-cog"></i> <?php echo __('', true);?></h4>
                <div class="options">
                    <a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
                </div>
            </div>
            <div class="panel-body taskings">
                <div class="form-group">
                    <span class="col-md-2 control-label"></span>
                    <div class="col-md-6">
                        <?php if (empty($this->data['Job']['onscene']) && empty($this->data['Job']['backon']) && empty($this->data['Job']['completed'])) { ?>
                        <?php echo $this->Html->link('<i class="fa fa-download"></i> '.__('On Scene'), array('action' => 'update', $this->data['Job']['id']), array('class' => 'btn btn-lg btn-primary btn-label btn-updatejob', 'data-type' => 'onscene', 'escape' => false));?>
                        <?php } else ?>
                        <?php if (!empty($this->data['Job']['onscene']) && empty($this->data['Job']['backon']) && empty($this->data['Job']['completed'])) { ?>
                        <?php echo $this->Html->link('<i class="fa fa-upload"></i> '.__('Back On'), array('action' => 'update', $this->data['Job']['id']), array('class' => 'btn btn-lg btn-success btn-label btn-updatejob', 'data-type' => 'backon', 'escape' => false));?>
                        <?php } else ?>
                        <?php if (!empty($this->data['Job']['onscene']) && !empty($this->data['Job']['backon']) && empty($this->data['Job']['completed'])) { ?>
                        <?php echo $this->Html->link('<i class="fa fa-check"></i> '.__('Mark Completed'), array('action' => 'update', $this->data['Job']['id']), array('class' => 'btn btn-lg btn-warning btn-label btn-updatejob', 'data-type' => 'completed', 'escape' => false));?>
                        <?php } else ?>
                        <?php if (!empty($this->data['Job']['onscene']) && !empty($this->data['Job']['backon']) && !empty($this->data['Job']['completed'])) { ?>
                        <?php echo $this->Html->link('<i class="fa fa-stop-circle"></i> '.__('Job Completed'), array('action' => 'view', $this->data['Job']['id']), array('class' => 'btn btn-lg btn-default btn-label disabled', 'escape' => false));?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-5">
        <div class="panel panel-orange">
            <div class="panel-heading">
                <h4><i class="fa fa-pencil"></i> <?php echo __('Client Signature', true);?></h4>
                <div class="options">
                    <a class="panel-collapse" href="javascript:;"><i class="fa fa-chevron-down"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->input('signoff_name', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Name')), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'div' => 'form-group'));?>  
                <?php echo $this->Form->hidden('signoff_sig');?>
                <div class="form-group">
                    <span class="col-md-2 control-label"><?php echo __('Signature');?></span>
                    <div class="col-xs-12 col-md-10">
                        <span class="form-control sig-wrapper">
                            <?php if (!empty($this->data['Job']['signoff_sig'])) { ?>
                            <img src="<?php echo $this->data['Job']['signoff_sig'];?>" alt="" class="img-responsive"/>
                            <?php } ?>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <span class="col-md-2 control-label"></span>
                    <div class="col-md-6">
                        <?php echo $this->Html->link('<i class="fa fa-pencil"></i> '.__('Client Signature'), '#', array('class' => 'btn btn-lg btn-default btn-label btn-signature', 'escape' => false));?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="panel panel-success">
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
                    <?php if ($j['status'] == '8'){ $disabled = 'disabled'; } else { $disabled = false; }?>
                    <div class="col-xs-12 col-md-8">
                        <?php echo $this->Form->input('JobItem.'.$j['id'].'.description', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Description')), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'div' => 'form-group', 'value' => $j['description'], $disabled));?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="col-xs-12 col-sm-12">
                            <?php echo $this->Form->input('JobItem.'.$j['id'].'.status', array('class' => 'form-control', 'label' => array('class' => 'col-md-3 control-label', 'text' => __('Status')), 'between' => '<div class="col-md-8">', 'after' => '</div>', 'div' => 'form-group', 'empty' => '', 'options' => array(__('Unallocated'), __('Allocated'), __('Tasked'), __('Draft'), 8 => __('Completed'), 9 => __('Cancelled')), 'selected' => $j['status'], $disabled));?>
                        </div>
                        <div class="col-xs-12 col-sm-12">
                            <?php echo $this->Form->input('JobItem.'.$j['id'].'.amount', array('class' => 'form-control', 'label' => array('class' => 'col-md-3 control-label', 'text' => __('Amount')), 'between' => '<div class="col-md-8">', 'after' => '</div>', 'div' => 'form-group', 'data-inputmask' => "'mask':'$ 999,999.99', 'greedy' : false, 'rightAlignNumerics' : false", 'type' => 'text', 'value' => $j['amount'], $disabled));?>
                        </div>
                    </div>
                    <?php if ($j['status'] < '8'){ ?>
                    <?php echo $this->Html->link('<i class="fa fa-trash"></i>', array('controller' => 'job_items', 'action' => 'delete', $j['id']), array('class' => 'jobitem-delete', 'data-jobitem' => 'jobitem-'.$j['id'], 'escape' => false));?>
                    <?php } ?>
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
<div id="sigCanvas" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <?php echo $this->Form->input('signature-name', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Name')), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'div' => 'form-group'));?> 
        <div class="form-group">
            <span class="col-md-2 control-label"><?php echo __('Signature');?></span>
            <div class="col-xs-10">
                <div class="m-signature-pad--body">
                    <canvas id="signature-pad"></canvas>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
      </div>
      <div class="modal-footer">
        <?php echo $this->Form->button(__('Close'), array('class' => 'btn btn-default btn-close', 'data-dismiss' => 'modal'));?>
        <?php echo $this->Form->button(__('Save'), array('class' => 'btn btn-primary btn-savesig pull-left'));?>
        <?php echo $this->Form->button(__('Reset'), array('class' => 'btn btn-inverse btn-reset pull-left'));?>
      </div>
    </div>
  </div>
</div>
<?php echo $this->Html->script(array(
    'plugins/timepicker/timepicker.js', 
    'plugins/bootstrap-typeahead/bootstrap-typeahead.min',
    'plugins/tinymce/tinymce.min',
    'plugins/tinymce/jquery.tinymce.min',
    'plugins/signature-pad/signature-pad.min',
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
    $('.btn-updatejob').click(function(e){
        e.preventDefault();
        $(this).find('i').removeClass().addClass('fa').html('<span class=\"fa fa-refresh fa-spin\"></span>');
        $('.taskings').load($(this).attr('href')+' .taskings > ', { 'type': $(this).data('type') }, function(e){

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
    jobitems();

    if ($('#signature-pad').length > 0) {
        var wrapper = document.getElementById('sigCanvas');
        var canvas = wrapper.querySelector('canvas');

        function resizeCanvas() {
            // When zoomed out to less than 100%, for some very strange reason,
            // some browsers report devicePixelRatio as less than 1
            // and only part of the canvas is cleared then.
            var ratio =  Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext('2d').scale(ratio, ratio);
        }
        window.onresize = resizeCanvas;   
        var signaturepad = new SignaturePad(canvas);

        $('.btn-signature').click(function(e){
            e.preventDefault();
            signaturepad.clear();
            $('#sigCanvas').modal();
        });

        $('#sigCanvas .btn-reset').click(function(e){
            e.preventDefault();
            signaturepad.clear();
        });

        $('#sigCanvas .btn-savesig').click(function(e){
            e.preventDefault();
            var _sig = signaturepad.toDataURL();
            if (_sig) {
                $('#JobSignoffSig').val(_sig);
                $('.sig-wrapper >').remove();
                $('.sig-wrapper').append($('<img>',{src:_sig, class: 'img-responsive'}));
            }
            $('#JobSignoffName').val($('#signature-name').val());
            $('#sigCanvas').modal('hide');
            signaturepad.clear();
            $.post('".$this->Html->url(array('controller' => 'jobs', 'action' => 'edit', $this->data['Job']['id']))."', $('#JobViewForm').serialize() );
        });

        $('#sigCanvas .btn-close').click(function(e){
            e.preventDefault();
            $('#sigCanvas').modal('hide');
            signaturepad.clear();
        });

        $('#sigCanvas').on('shown.bs.modal', function(){
            resizeCanvas();
        });
    }

});
" , array('inline' => false));?>