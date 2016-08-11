<?php $this->Html->pageClass = 'users';?>
<?php $this->Html->pageTitle = __('Manage Users');?>
<?php $this->Html->addCrumb(__('Users'), array('controller' => 'users', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Add User'));?>
<?php echo $this->Form->create('User', array('type' => 'file'));?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Add User');?></h4>
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
<div class="row">
	<div class="col-md-6 col-md-offset-6">
		<div class="panel panel-inverse">
			<div class="panel-heading">
				<h4><i class="fa fa-question"></i> <?php echo __('Help');?></h4>
			</div>
			<div class="panel-body">
				<div class="form-horizontal row-border">
					<h4><?php echo __('Roles');?></h4>
					<p><?php echo __('Each user should be assigned a role. Roles allow users to access certain areas of the app whilst restricting other users.');?> <?php echo __('The below list is indicative of the roles currently used.');?></p>
					<ul>
						<li><strong><?php echo __('Admin');?></strong> <?php echo __('This role has exclusive access to all functionality assigned to your company. Generally you should only have one Admin user. Admin users can add/edit/delete jobs,quotes & customers. They can also export data.');?></li>
						<li><strong><?php echo __('Staff');?></strong> <?php echo __('This role has restricted access to jobs, quotes & customers. Staff cannot delete jobs, quotes or customers. They cannot add users but can view them.');?></li>
						<li><strong><?php echo __('Users');?></strong> <?php echo __('This role has the most restrictions. This role can only view and update jobs, view and sent quotes and view customers. We recommend this role be allocated to those users who will only be processing jobs.');?></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>