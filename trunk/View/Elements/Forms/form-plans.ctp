<div class="form-group">
	<label class="col-md-2 control-label"> <span class="pull-left"><?php echo __('Current Plan');?></span></label>
	<div class="col-md-10">
		<span class="form-control"><strong><?php echo $this->data['Plan']['name'];?></strong></span>
		<?php if ($this->data['Plan']['type'] === 'try') { ?>
		<span class="label label-danger label-lg"><?php echo __('Days left of trial');?>: <strong><?php echo 30 - floor(strtotime($this->data['Client']['created'])/(60*60*24));?></strong></span>
		<?php } ?>
	</div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label"> <span class="pull-left"><?php echo __('Subscription ID');?></span></label>
	<div class="col-md-10">
		<span class="form-control"><strong><?php echo $this->data['Client']['subscription_id'];?></strong></span>
	</div>
</div>
<?php if (!empty($plans)) { ?>
<div class="form-group">
	<table class="table table-condensed" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th>
				<?php echo __('Plan');?>
			</th>
			<th class="hidden-xs">
				<?php echo __('Details');?>
			</th>
			<th>
				<?php echo __('Pricing');?>
			</th>
			<th>
				<?php echo __('Subscribe');?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($plans as $p) { ?>
	<?php $_class = ($p['Plan']['id'] == $this->Session->read('Auth.User.Client.plan_id'))? 'info': '';?>
		<tr class="<?php echo $_class;?>">
			<td>
				<?php echo $p['Plan']['name'];?>
			</td>
			<td class="hidden-xs">
				<?php echo $p['Plan']['description'];?>
			</td>
			<td>
				<span class="planprice"><?php echo $this->Number->currency($p['Plan']['billing'], $this->Session->read('Auth.User.locale'));?></span>
				<br/><span class="label label-default"><?php echo __('billed monthly');?> </span>
			</td>
			<td>
			<?php if(empty($_class) && $p['Plan']['id'] != 1) { ?>
				<?php echo $this->Html->link(__('Subscribe'), array('controller' => 'clients', 'action' => 'subscribe', base64_encode(json_encode($p['Plan']))), array('class' => 'btn btn-primary', 'escape' => false));?>
			<?php } ?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
	</table>
</div>
<?php } ?>