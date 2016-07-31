<?php $this->Html->pageClass = 'customers';?>
<?php $this->Html->pageTitle = __('Add Customer');?>
<?php $this->Html->addCrumb(__('Customers'), array('controller' => 'customers', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Add Customer'));?>
<?php echo $this->Form->create('Customer');?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Customer Details');?></h4>
			</div>
			<div class="panel-body">
				<div class="form-horizontal row-border">
				<?php echo $this->element('Forms/form-customers');?>
				</div>
			</div>
			<?php echo $this->fetch('panel-footer');?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-cog"></i> <?php echo __('Contact Information');?></h4>
			</div>
			<div class="panel-body">
				<div class="form-horizontal row-border">
				<?php echo $this->element('Forms/form-customers-parameters');?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>