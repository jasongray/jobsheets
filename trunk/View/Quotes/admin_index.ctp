<?php $this->Html->pageClass = 'quotes';?>
<?php $this->Html->pageTitle = __('Quote List');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Admin Quotes'));?>
<?php echo $this->Html->css(array('datatables'), array('inline' => false));?>
<?php echo $this->start('heading');?>
<div class="options">
    <div class="btn-toolbar">
        <?php echo $this->Html->link('<i class="fa fa-plus"></i> ' . __('New Quote'), array('controller' => 'quotes', 'action' => 'add'), array('class' => 'btn btn-success', 'escape' => false));?>
    </div>
</div>
<?php echo $this->end();?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Quotes', true);?></h4>
				
			</div>
			<div class="panel-body">
				<table cellpadding="0" cellspacing="0" class="table table-hover table-striped">
					<thead>
					<tr>
						<th class="icon"><?php echo __('Id');?></th>
						<th><?php echo $this->Paginator->sort('title', __('Quote'));?></th>
						<th><?php echo $this->Paginator->sort('client_id', __('Client'));?></th>
						<th><?php echo $this->Paginator->sort('status', __('Status'));?></th>
						<th class="actions"><?php echo __('Actions');?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($data as $j){ ?>
					<tr>
						<td><?php echo $this->Html->link($j['Quote']['id'], array('action' => 'edit', $j['Quote']['id']), array('class'=>'edit-link'));?></td>
						<td><?php echo $this->Html->link($j['Quote']['title'], array('action' => 'edit', $j['Quote']['id']), array('class'=>'edit-link'));?></td>
						<td><?php echo $this->Html->link($j['Client']['name'], array('action' => 'edit', $j['Quote']['id']), array('escape' => false));?></td>
						<td><?php echo $this->Html->quoteStatus($j['Quote']['status']); ?></td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-search"></i>', array('action' => 'view', $j['Quote']['id']), array('escape' => false, 'class' => 'bs-tooltip', 'title' => 'View', 'data-toggle' => 'tooltip')); ?>
							<?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array('action' => 'edit', $j['Quote']['id']), array('escape' => false, 'class' => 'bs-tooltip', 'title' => 'Edit', 'data-toggle' => 'tooltip')); ?>
							<?php echo $this->Html->link('<i class="fa fa-trash"></i>', array('action' => 'delete', $j['Quote']['id']), array('escape' => false, 'class' => 'bs-tooltip trash', 'title' => 'Delete', 'data-toggle' => 'tooltip', 'data-alert-msg' => sprintf(__('Are you sure you want to delete this quote %s?'), $j['Quote']['id']))); ?>
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