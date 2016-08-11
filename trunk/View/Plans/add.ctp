<?php $this->Html->pageClass = 'plans';?>
<?php $this->Html->pageTitle = __('Manage Plans');?>
<?php $this->Html->addCrumb(__('Plans'), array('controller' => 'plans', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Add Plan'));?>
<?php echo $this->Form->create('Plan', array('class' => 'form-horizontal row-border', 'type' => 'file'));?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-map"></i> <?php echo __('Add Plan');?></h4>
			</div>
			<div class="panel-body">
				<?php echo $this->element('Forms/form-plans');?>
			</div>
			<?php echo $this->fetch('panel-footer');?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4><i class="fa fa-paypal"></i> <?php echo __('Paypal Settings');?></h4>
			</div>
			<div class="panel-body">
				<?php echo $this->element('Forms/form-plans-parameters');?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>