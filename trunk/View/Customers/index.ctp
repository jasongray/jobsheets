<?php $this->Html->pageClass = 'customers';?>
<?php $this->Html->pageTitle = __('Customer List');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('My Customers'));?>
<?php echo $this->Html->css(array('datatables'), array('inline' => false));?>
<?php echo $this->start('heading');?>
<div class="options">
    <div class="btn-toolbar">
        <?php echo $this->Html->link('<i class="fa fa-plus"></i> ' . __('New Customer'), array('controller' => 'customers', 'action' => 'add'), array('class' => 'btn btn-primary', 'escape' => false));?>
    </div>
</div>
<?php echo $this->end();?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Customers', true);?></h4>
				
			</div>
			<div class="panel-body">
				<table cellpadding="0" cellspacing="0" class="table table-hover table-striped">
					<thead>
					<tr>
						<th class="icon"><?php echo __('Id');?></th>
						<th><?php echo $this->Paginator->sort('name', __('Customer'));?></th>
						<th><?php echo $this->Paginator->sort('status', __('Location'));?></th>
						<th class="actions"><?php echo __('Actions');?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($data as $j){ ?>
					<tr>
						<td><?php echo $this->Html->link($j['Customer']['id'], array('action' => 'edit', $j['Customer']['id']), array('class'=>'edit-link'));?></td>
						<td><?php echo $this->Html->link($j['Customer']['name'], array('action' => 'edit', $j['Customer']['id']), array('class'=>'edit-link'));?></td>
						<td><?php echo $j['Customer']['suburb']; ?></td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array('action' => 'edit', $j['Customer']['id']), array('escape' => false, 'class' => 'bs-tooltip', 'title' => 'Edit', 'data-toggle' => 'tooltip')); ?>
							<?php echo $this->Html->link('<i class="fa fa-trash"></i>', array('action' => 'delete', $j['Customer']['id']), array('escape' => false, 'class' => 'bs-tooltip trash', 'title' => 'Delete', 'data-toggle' => 'tooltip', 'data-alert-msg' => sprintf(__('Are you sure you want to delete this quote %s?'), $j['Customer']['id']))); ?>
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