<?php $this->Html->pageClass = 'jobs';?>
<?php $this->Html->pageTitle = __('Job List');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Current Jobs'));?>
<?php echo $this->Html->css(array('datatables'), array('inline' => false));?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Current Jobs', true);?></h4>
				
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
						<td>
							<?php echo $this->Html->link($j['Job']['id'], array('action' => 'view', $j['Job']['id']), array('class'=>'edit-link'));?>
							<?php if(time() > strtotime($j['Job']['dueby'])) { ?>
		                        <span class="badge badge-danger"><?php echo __('Overdue');?></span>
		                    <?php } ?>
						</td>
						<td>
							<?php echo $this->Html->link($j['Job']['reference'], array('action' => 'view', $j['Job']['id']), array('class'=>'edit-link'));?>
						</td>
						<td>
							<?php echo $this->Html->jobStatus($j['Job']['status']); ?>
						</td>
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-search"></i>', array('action' => 'view', $j['Job']['id']), array('escape' => false, 'class' => 'bs-tooltip', 'title' => 'View', 'data-toggle' => 'tooltip')); ?>
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