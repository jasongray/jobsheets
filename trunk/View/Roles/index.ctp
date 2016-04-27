<?php $this->Html->pageClass = 'roles';?>
<?php $this->Html->pageTitle = __('Manage User Roles');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Roles'));?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-bullseye"></i> <?php echo __('User Roles', true);?></h4>
				
			</div>
			<div class="panel-body">
				<?php echo $this->Html->link(__('Create Role'), array('action' => 'add'), array('class'=>'btn btn-info', 'escape' => false))?>
				<table cellpadding="0" cellspacing="0" class="table table-hover table-striped">
					<thead>
					<tr>
						<th class="icon">Id</th>
						<th><?php echo __('Role');?></th>
						<th class="actions"><?php __('Actions');?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($roles as $role){ ?>
					<tr>
						<td><?php echo $this->Html->link($role['Role']['id'], array('action' => 'edit', $role['Role']['id']), array('class'=>'edit-link'));?></td>
						<td><?php echo $this->Html->link($role['Role']['name'], array('action' => 'edit', $role['Role']['id']));?></td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array('action' => 'edit', $role['Role']['id']), array('escape' => false, 'class' => 'bs-tooltip', 'data-original-title' => 'Edit')); ?>
							<?php echo $this->Html->link('<i class="fa fa-trash"></i>', array('action' => 'delete', $role['Role']['id']), array('escape' => false, 'class' => 'bs-tooltip trash', 'data-original-title' => 'Delete', 'data-alert-msg' => sprintf(__('Are you sure you want to delete the %s role?'), $role['Role']['name']))); ?>
						</td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
				<?php echo $this->element('paginator');?>
			</div>
		</div>
	</div>
</div>