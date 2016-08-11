<?php $this->Html->pageClass = 'clients';?>
<?php $this->Html->pageTitle = __('My Account');?>
<?php $this->Html->addCrumb(__('My Account'));?>
<?php echo $this->Form->create('Client', array('class' => 'form-horizontal row-border', 'type' => 'file'));?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-cogs"></i> <?php echo __('Edit Account');?></h4>
			</div>
			<div class="panel-body">
				<div class="form-horizontal row-border">
				<?php echo $this->element('Forms/form-clients-profile');?>
				</div>
			</div>
			<?php echo $this->fetch('panel-footer');?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-flag"></i> <?php echo __('Plans');?></h4>
			</div>
			<div class="panel-body">
				<div class="form-horizontal row-border">
				<?php echo $this->element('Forms/form-plans-profile');?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>