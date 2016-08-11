<div class="well">
	<h4><?php echo __('Your subscribing to the');?> "<?php echo $plan['Plan']['name'];?>" <?php echo __('plan');?></h4>
	<div class="row">
		<div class="col-sm-4">
			<?php echo $plan['Plan']['description'];?>
		</div>
		<div class="col-sm-4 col-sm-offset-4">
			<span class="planpricelg"><?php echo $this->Number->currency($plan['Plan']['amount']*1.1, $this->Session->read('Auth.User.locale'));?></span>
			<br/><span class="label label-default"><?php echo __('billed monthly');?> </span>
		</div>
	</div>
</div>
<div class="form-group text-center">
	<ul class="card_logos">
		<li class="card_visa"><?php echo __('Visa');?></li>
		<li class="card_mastercard"><?php echo __('Mastercard');?></li>
		<li class="card_amex"><?php echo __('American Express');?></li>
		<li class="card_discover"><?php echo __('Discover');?></li>
		<li class="card_jcb"><?php echo __('JCB');?></li>
		<li class="card_diners"><?php echo __('Diners Club');?></li>
	</ul>
</div>
<div class="form-group">
<?php echo $this->Form->input('CC.number', array('div' => false, 'class' => 'form-control ccnumber', 'label' => array('text' => __('Card Number'), 'class' => 'col-md-4 control-label'), 'between' => '<div class="col-md-8"><div class="input-group">', 'after' => '<span class="ccnumber input-group-addon"><i class="fa fa-credit-card"></i></span></div><span class="help-block">'.__('The card number with no spaces or dashes').'</span></div>', 'size' => 20, 'type' => 'text', 'pattern' => '[0-9]{13,20}', 'required' => 'required', 'autocomplete' => 'off')); ?>
<?php if (isset($errors['number'])) { ?>
	<div class="error-message">
		<?php echo implode('<br/>', $errors['number']);?>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<label class="col-md-4 control-label"><?php echo __('Expiry');?></label>
	<div class="col-sm-12 col-md-8">
		<div class="row">
			<div class="col-sm-6">
				<?php echo $this->Form->input('CC.exmonth', array('div' => false, 'class' => 'form-control col-sm-6', 'label' => array('text' => __('Month'), 'class' => 'col-sm-6'), 'empty' => '', 'options' => array('01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' => '05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12'), 'type' => 'select', 'required' => 'required', 'autocomplete' => 'off'));?>
			</div>
			<div class="col-sm-6">
				<?php $years = array(); 
				$year = date('Y');
				for ($i=0; $i<16;$i++){
					$years[$year+$i] = $year+$i;
				} ?>
				<?php echo $this->Form->input('CC.exyear', array('div' => false, 'class' => 'form-control col-sm-6', 'label' => array('text' => __('Year'), 'class' => 'col-sm-6'), 'empty' => '', 'options' => $years, 'type' => 'select', 'required' => 'required', 'autocomplete' => 'off'));?>
			</div>
		</div>
	</div>
<?php if (isset($errors['exmonth'])) { ?>
	<div class="error-message">
		<?php echo implode('<br/>', $errors['exmonth']);?>
	</div>
<?php } ?>
</div>
<div class="form-group">
<?php echo $this->Form->input('CC.ccv', array('div' => false, 'class' => 'form-control', 'label' => array('text' => __('Security code'), 'class' => 'col-md-4 control-label'), 'between' => '<div class="col-md-8"><div class="input-group col-md-3">', 'after' => '</div><span class="help-block">'.__('The last 3 digits on the reverse side of your credit card').'</span></div>', 'size' => 20, 'type' => 'text', 'pattern' => '[0-9]{3,4}', 'required' => 'required', 'autocomplete' => 'off')); ?>
<?php if (isset($errors['ccv'])) { ?>
	<div class="error-message">
		<?php echo implode('<br/>', $errors['ccv']);?>
	</div>
<?php } ?>
</div>
<div class="well">
	<h4><i class="fa fa-lock fa-2x"></i></h4>
	<p><?php echo __('All payments are processed through PayPal. Paypal is a secure and hassle free merchant service recognised worldwide.');?><?php echo __('By submitting your payment you are agreeing to JobSheets debiting your credit card monthly for the set price.');?></p>
	<p><?php echo __('Any accounts issues please contact us directly on accounts@jobsheets.com.au');?></p>
</div>

<?php echo $this->start('panel-footer');?>
<div class="panel-footer">
	<div class="row">
		<div class="col-md-12">
			<div class="btn-toolbar">
				<?php echo $this->Form->submit('Submit Payment', array('class'=>'btn btn-primary pull-right', 'div' => false)); ?>
				<?php echo $this->Html->link('Cancel', array('controller' => 'clients', 'action' => 'account', 'plugin' => false), array('class' => 'btn btn-default pull-left')); ?>
				<?php echo $this->Form->hidden('CC.method', array('value' => 'credit_card'));?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->end();?>

<?php echo $this->Html->script(array('plugins/creditcard/jquery.creditCardTypeDetector'), array('inline' => false));?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function(){
	$('.ccnumber').creditCardTypeDetector({
		'credit_card_logos':'.card_logos',
		'credit_card_name':'.cctype',
	});
});", array('inline' => false));?>