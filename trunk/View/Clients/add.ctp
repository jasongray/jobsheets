<?php $this->Html->pageClass = 'client';?>
<?php $this->Html->pageTitle = __('Add Client');?>
<?php $this->Html->addCrumb(__('Clients'), array('controller' => 'clients', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Add Client'));?>
<?php echo $this->Form->create('Client');?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Client Details');?></h4>
			</div>
			<div class="panel-body">
				<div class="form-horizontal row-border">
				<?php echo $this->element('Forms/form-clients');?>
				</div>
			</div>
			<?php echo $this->fetch('panel-footer');?>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>