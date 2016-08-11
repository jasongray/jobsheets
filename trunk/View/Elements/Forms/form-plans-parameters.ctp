<?php echo $this->Form->input('type', array('div' => 'form-group wysiwyg', 'class' => 'form-control', 'label' => array('text' => __('Type'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'empty' => '', 'options' => array('TRIAL' => __('Trial'), 'REGULAR' => __('Regular')))); ?>
<?php echo $this->Form->input('frequency', array('div' => 'form-group wysiwyg', 'class' => 'form-control', 'label' => array('text' => __('Frequency'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'empty' => '', 'options' => array('MONTH' => __('Monthly'), 'YEAR' => __('Annually')))); ?>
<?php echo $this->Form->input('intervals', array('div' => 'form-group wysiwyg', 'class' => 'form-control', 'label' => array('text' => __('Interval'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '<span class="help-block">'.__('Billing intervals. Set 1 for each month, 12 for annually.').'</span></div>')); ?>
<?php echo $this->Form->input('cycles', array('div' => 'form-group wysiwyg', 'class' => 'form-control', 'label' => array('text' => __('Cycles'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '<span class="help-block">'.__('The number of billing cycles.').'</span></div>')); ?>
<?php echo $this->Form->input('amount', array('div' => 'form-group wysiwyg', 'class' => 'form-control', 'label' => array('text' => __('Amount'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '<span class="help-block">'.__('Amount excluding GST.').'</span></div>')); ?>
<?php if (!empty($this->data['Plan']['billing_plan_id'])){ ?>
<?php echo $this->Form->hidden('billing_plan_id');?>
<div id="activateplan" class="form-group">
	<div class="col-md-10 col-md-offset-2">
		<?php $_action = $this->request->data['Plan']['active'] == 0? 'activate': 'deactivate'; ?>
		<?php echo $this->Html->link(__(sprintf('%s Plan', ucwords($_action))), array('controller' => 'plans', 'action' => $_action, $this->data['Plan']['billing_plan_id']), array('class' => 'btn btn-sm btn-inverse activateplan', 'escape' => false));?>
	</div>
</div>
<?php echo $this->Html->scriptBlock("
$(document).ready(function(){
	var activateclick = function(){
		$('.activateplan').click(function(e){
			e.preventDefault();
			$.post($(this).attr('href'), function(data){
				var data = (data);
				if(data.code == 200) {
					$('#activateplan').load(window.location+' #activateplan >', function(){
						activateclick();
					});
				}
			});
		});
	}
	activateclick();
});", array('inline' => false));
} ?>