<?php $this->Html->pageClass = 'clients';?>
<?php $this->Html->pageTitle = __('My Account');?>
<?php $this->Html->addCrumb(__('My Account'), array('controller' => 'clients', 'action' => 'account'));?>
<?php $this->Html->addCrumb(__('Subscribe'));?>
<?php echo $this->Form->create('Client', array('class' => 'form-horizontal row-border', 'type' => 'file'));?>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-money"></i> <?php echo __('Enter your payment details');?></h4>
			</div>
			<div class="panel-body">
				<div class="form-horizontal row-border">
					<?php echo $this->element('Forms/form-clients-subscribe');?>
				</div>
			</div>
			<?php echo $this->fetch('panel-footer');?>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>