<?php $this->Html->pageClass = 'clients';?>
<?php $this->Html->pageTitle = __('Client List');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Admin Clients'));?>
<?php echo $this->Html->css(array('datatables'), array('inline' => false));?>
<?php echo $this->start('heading');?>
<div class="options">
    <div class="btn-toolbar">
        <?php echo $this->Html->link('<i class="fa fa-plus"></i> ' . __('New Client'), array('controller' => 'clients', 'action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false));?>
    </div>
</div>
<?php echo $this->end();?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Clients', true);?></h4>
				
			</div>
			<div class="panel-body">
				<table cellpadding="0" cellspacing="0" class="table table-hover table-striped">
					<thead>
					<tr>
						<th class="icon"><?php echo __('Id');?></th>
						<th><?php echo $this->Paginator->sort('name', __('Client'));?></th>
						<th><?php echo $this->Paginator->sort('status', __('Status'));?></th>
						<th><?php echo $this->Paginator->sort('plan_id', __('Plan'));?></th>
						<th class="actions"><?php echo __('Actions');?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($data as $j){ ?>
					<tr>
						<td><?php echo $this->Html->link($j['Client']['id'], array('action' => 'edit', $j['Client']['id']), array('class'=>'edit-link'));?></td>
						<td><?php echo $this->Html->link($j['Client']['name'], array('action' => 'edit', $j['Client']['id']), array('class'=>'edit-link'));?></td>
						<td><?php if ($j['Client']['status'] === '1'){ echo '<span class="label label-success">'.__('Active').'</span>'; } else { echo '<span class="label label-inverse">'.__('Inactive').'</span>';} ?></td>
						<td><?php echo $j['Plan']['name']; ?></td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array('action' => 'edit', $j['Client']['id']), array('escape' => false, 'class' => 'bs-tooltip', 'title' => 'Edit', 'data-toggle' => 'tooltip')); ?>
							<?php echo $this->Html->link('<i class="fa fa-trash"></i>', array('action' => 'delete', $j['Client']['id']), array('escape' => false, 'class' => 'bs-tooltip trash', 'title' => 'Delete', 'data-toggle' => 'tooltip', 'data-alert-msg' => sprintf(__('Are you sure you want to delete this client %s?'), $j['Client']['id']))); ?>
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