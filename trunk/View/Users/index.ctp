<?php $this->Html->pageClass = 'users';?>
<?php $this->Html->pageTitle = __('Manage Users');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Users'));?>
<?php echo $this->Html->css(array('datatables'), array('inline' => false));?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('User List', true);?></h4>
				
			</div>
			<div class="panel-body">
				<?php echo $this->Html->link('Create User', array('action' => 'add'), array('class'=>'btn btn-warning', 'escape' => false))?>
				<table cellpadding="0" cellspacing="0" class="table table-hover table-striped">
					<thead>
					<tr>
						<th class="icon hidden-sm"><?php echo __('Id');?></th>
						<th colspan="2"><?php echo $this->Paginator->sort('username', __('Name'));?></th>
						<th><?php echo $this->Paginator->sort('email', __('Email'));?></th>
						<th class="hidden-sm"><?php echo $this->Paginator->sort('role_id', __('Role'));?></th>
						<th><?php echo $this->Paginator->sort('active', __('Active'));?></th>
						<th><?php echo $this->Paginator->sort('lastactive', __('Last Login'));?></th>
						<th class="actions hidden-sm"><?php echo __('Actions');?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($data as $u){ ?>
						<?php if( empty($u['User']['avatar']) ) { 
							$_img = 'avatar-1.jpg';
						} else {
							$_img = $u['User']['avatar'];
						}
						$img = $this->Resize->image($_img, 30, 30, false, array('alt' => ''));
						?>
					<tr>
						<td class="hidden-sm"><?php echo $this->Html->link($u['User']['id'], array('action' => 'edit', $u['User']['id']), array('class'=>'edit-link'));?></td>
						<td><span class="hidden-sm"><?php echo $img;?></span></td>
						<td><?php echo $u['User']['firstname'];?> <?php echo $u['User']['lastname'];?></td>
						<td><?php echo $this->Html->link($u['User']['email'], array('action' => 'edit', $u['User']['id']), array('escape' => false));?></td>
						<td class="hidden-sm"><?php echo $u['Role']['name'];?></td>
						<td><?php if ($u['User']['status'] == 1){ echo '<span class="label label-success">'.__('Active').'</span>'; } else { '<span class="label label-warning">'.__('Deactive').'</span>';} ?></td>
						<td><?php if (!empty($u['User']['lastactive'])){ echo $this->Time->timeAgoInWords($u['User']['lastactive'], array('end' => '+1 year')); } else { echo __('Never'); } ?></td>
						<td class="actions hidden-sm">
							<?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array('action' => 'edit', $u['User']['id']), array('escape' => false, 'class' => 'bs-tooltip', 'data-original-title' => 'Edit')); ?>
							<?php echo $this->Html->link('<i class="fa fa-trash"></i>', array('action' => 'delete', $u['User']['id']), array('escape' => false, 'class' => 'bs-tooltip trash', 'data-original-title' => 'Delete', 'data-alert-msg' => sprintf(__('Are you sure you want to delete the %s role?'), $u['User']['email']))); ?>
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