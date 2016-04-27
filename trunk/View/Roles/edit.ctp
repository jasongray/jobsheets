<?php $this->Html->pageClass = 'roles';?>
<?php $this->Html->pageTitle = __('Manage User Roles');?>
<?php $this->Html->addCrumb(__('Roles'), array('controller' => 'roles', 'action' => 'index', 'admin' => 'admin'));?>
<?php $this->Html->addCrumb(__('Edit Role'));?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-bullseye"></i> <?php echo __('Edit Role');?></h4>
			</div>
			<div class="panel-body">
				<?php echo $this->element('Forms/form-roles');?>
			</div>
		</div>
	</div>
</div>