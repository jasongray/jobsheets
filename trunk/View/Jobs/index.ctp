<?php $this->Html->pageClass = 'jobs';?>
<?php $this->Html->pageTitle = __('Job List');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Current Jobs'));?>
<?php echo $this->Html->css(array('datatables'), array('inline' => false));?>
<?php echo $this->start('heading');?>
<div class="options">
    <div class="btn-toolbar">
        <?php echo $this->Html->link('<i class="fa fa-plus"></i> ' . __('New Job'), array('controller' => 'jobs', 'action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false));?>
    </div>
</div>
<?php echo $this->end();?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Current Jobs', true);?></h4>
				<div class="options">
					<ul class="nav nav-tabs">
						<li<?php if($class_status == 'default'){ echo ' class="active"';}?>>
							<?php echo $this->Html->link(__('Outstanding'), array('controller' => 'jobs', 'action' => 'index'));?>
						</li>
						<li<?php if($class_status == 'completed'){ echo ' class="active"';}?>>
							<?php echo $this->Html->link(__('Completed'), array('controller' => 'jobs', 'action' => 'index', 'status' => 'completed'));?>
						</li>
						<li<?php if($class_status == 'cancelled'){ echo ' class="active"';}?>>
							<?php echo $this->Html->link(__('Cancelled'), array('controller' => 'jobs', 'action' => 'index', 'status' => 'cancelled'));?>
						</li>
					</ul>
				</div>
			</div>
			<div class="panel-body">
				<table cellpadding="0" cellspacing="0" class="table table-hover table-striped">
					<thead>
					<tr>
						<th class="icon"><?php echo __('Id');?></th>
						<th><?php echo $this->Paginator->sort('reference', __('Reference'));?></th>
						<th><?php echo $this->Paginator->sort('status', __('Status'));?></th>
						<th class="actions"><?php echo __('Actions');?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($data as $j){ ?>
					<tr>
						<td><?php echo $this->Html->link($j['Job']['id'], array('action' => 'edit', $j['Job']['id']), array('class'=>'edit-link'));?></td>
						<td><?php echo $this->Html->link($j['Job']['reference'], array('action' => 'edit', $j['Job']['id']), array('class'=>'edit-link'));?></td>
						<td><?php echo $this->Html->jobStatus($j['Job']['status']); ?></td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-search"></i>', array('action' => 'view', $j['Job']['id']), array('escape' => false, 'class' => 'bs-tooltip', 'title' => 'View', 'data-toggle' => 'tooltip')); ?>
							<?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array('action' => 'edit', $j['Job']['id']), array('escape' => false, 'class' => 'bs-tooltip', '-title' => 'Edit', 'data-toggle' => 'tooltip')); ?>
							<?php echo $this->Html->link('<i class="fa fa-trash"></i>', array('action' => 'delete', $j['Job']['id']), array('escape' => false, 'class' => 'bs-tooltip trash', 'title' => 'Delete', 'data-toggle' => 'tooltip', 'data-alert-msg' => sprintf(__('Are you sure you want to delete job %s?'), $j['Job']['id']))); ?>
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