<?php $this->Html->pageClass = 'users';?>
<?php $this->Html->pageTitle = __('Manage Users');?>
<?php $this->Html->addCrumb(__('Users'), array('controller' => 'users', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Edit User'));?>
<?php echo $this->Form->create('User', array('class' => 'form-horizontal row-border', 'type' => 'file'));?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Edit User');?></h4>
			</div>
			<div class="panel-body">
				<div class="form-horizontal row-border">
				<?php echo $this->element('Forms/form-users');?>
				</div>
			</div>
			<?php echo $this->fetch('panel-footer');?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-cog"></i> <?php echo __('User Details');?></h4>
			</div>
			<div class="panel-body">
				<div class="form-horizontal row-border">
				<?php echo $this->element('Forms/form-users-parameters');?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>