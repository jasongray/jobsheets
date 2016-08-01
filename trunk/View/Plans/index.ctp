<?php $this->Html->pageClass = 'plans';?>
<?php $this->Html->pageTitle = __('Manage Plans');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Plans'));?>
<?php echo $this->Html->css(array('datatables'), array('inline' => false));?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-map"></i> <?php echo __('Plans', true);?></h4>
				
			</div>
			<div class="panel-body">
				<?php echo $this->Html->link(__('Create Plan'), array('action' => 'add'), array('class'=>'btn btn-info', 'escape' => false))?>
				<table cellpadding="0" cellspacing="0" class="table table-hover table-striped">
					<thead>
					<tr>
						<th class="icon">Id</th>
						<th><?php echo __('Plan');?></th>
						<th><?php echo __('Billing ID');?></th>
						<th><?php echo __('Status');?></th>
						<th class="actions"><?php __('Actions');?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($plans as $plan){ ?>
					<tr>
						<td><?php echo $this->Html->link($plan['Plan']['id'], array('action' => 'edit', $plan['Plan']['id']), array('class'=>'edit-link'));?></td>
						<td><?php echo $this->Html->link($plan['Plan']['name'], array('action' => 'edit', $plan['Plan']['id']));?></td>
						<td><?php echo $this->Html->link($plan['Plan']['billing_plan_id'], array('action' => 'edit', $plan['Plan']['id']));?></td>
						<td><?php if ($plan['Plan']['active'] == 1){ echo '<span class="label label-success">'.__('Active').'</span>'; } else { echo '<span class="label label-warning">'.__('Deactive').'</span>';} ?></td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array('action' => 'edit', $plan['Plan']['id']), array('escape' => false, 'class' => 'bs-tooltip', 'data-original-title' => 'Edit')); ?>
							<?php echo $this->Html->link('<i class="fa fa-trash"></i>', array('action' => 'delete', $plan['Plan']['id']), array('escape' => false, 'class' => 'bs-tooltip trash', 'data-original-title' => 'Delete', 'data-alert-msg' => sprintf(__('Are you sure you want to delete the %s plan?'), $plan['Plan']['name']))); ?>
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