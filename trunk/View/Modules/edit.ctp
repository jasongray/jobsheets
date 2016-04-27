<?php $this->Html->pageClass = 'modules';?>
<?php $this->Html->pageTitle = __('Manage Modules');?>
<?php $this->Html->addCrumb(__('Modules'), array('controller' => 'modules', 'action' => 'index', 'plugin' => false));?>
<?php $this->Html->addCrumb(__('Edit Module'));?>

<?php echo $this->Form->create('Module', array('class' => 'form-horizontal row-border', 'type' => 'file'));?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-folder"></i> <?php echo __('Module Information', true);?></h4>
			</div>
			<div class="panel-body">
				<div class="form-horizontal row-border">
				<?php echo $this->element('Forms/form-modules');?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-gray">
			<div class="panel-heading">
				<h4><i class="fa fa-cog"></i> <?php echo __('Module Parameters', true);?></h4>
			</div>
			<div class="panel-body">
				<div class="form-horizontal row-border">
					<?php echo $this->Module->loadparamsform($this->data['Module']['module_file']);?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>