<?php $this->Html->pageClass = 'modules';?>
<?php $this->Html->pageTitle = __('Modules Manager');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Modules'));?>
<?php echo $this->Html->css(array('datatables'), array('inline' => false));?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-cloud"></i> <?php echo __('Modules');?></h4>
			</div>
			<div class="panel-body">
				<?php echo $this->Html->link('Add Module', array('controller' => 'modules', 'action' => 'add', 'plugin' => false), array('class'=>'btn btn-info', 'escape' => false))?>
				<table cellpadding="0" cellspacing="0" class="table table-striped">
					<thead>
					<tr>
						<th class="icon"><?php echo __('Id');?></th>
						<th><?php echo __('Module Title');?></th>
						<th class="icon"><?php echo  __('Position');?></th>
						<th colspan="2"><?php echo  __('Ordering');?></th>
						<th class="icon"><?php echo  __('Published');?></th>
						<th class="actions"><?php __('Actions');?></th>
					</tr>
					</thead>
					<tbody>
					<?php
					if (isset($modules)) {
						$k = 1;
						for($i=0;$i<count($modules);$i++){ 
							$s = $modules[$i];
							$m = $modules[$i]['Module']['ordering'];
							$n = isset($modules[$i+1]['Module']['ordering'])? $modules[$i+1]['Module']['ordering']: 0;
							$p = isset($modules[$i-1]['Module']['ordering'])? $modules[$i-1]['Module']['ordering']: 0;
						?>
						<tr>
							<td><?php echo $this->Html->link($s['Module']['id'], array('controller' => 'modules', 'action' => 'edit', 'plugin' => false, $s['Module']['id']), array('class'=>'edit-link'));?></td>
							<td><?php echo $this->Html->link($s['Module']['title'], array('controller' => 'modules', 'action' => 'edit', 'plugin' => false, $s['Module']['id']));?></td>
							<td class="dates"><?php echo $s['Module']['position']; ?>&nbsp;</td>
							<td><?php if($m != 1){ echo $this->Html->link('<i class="icon-arrow-up"></i>', array('controller' => 'modules', 'action' => 'orderup', 'plugin' => false, $s['Module']['id']), array('escape'=>false));}?></td>
							<td><?php if($i < count($modules) - 1 && $n != 1){ echo $this->Html->link('<i class="icon-arrow-down"></i>', array('controller' => 'modules', 'action' => 'orderdown', 'plugin' => false, $s['Module']['id']), array('escape'=>false));}?></td>
							<td><?php if ($s['Module']['published'] == 1){ echo '<span class="label label-success">'.__('Published').'</span>'; } else { '<span class="label label-warning">'.__('Unpublished').'</span>';} ?></td>
							<td class="actions">
								<?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array('controller' => 'modules', 'action' => 'edit', 'plugin' => false, $s['Module']['id']), array('escape' => false, 'class' => 'bs-tooltip', 'data-original-title' => 'Edit')); ?>
								<?php echo $this->Html->link('<i class="fa fa-trash"></i>', array('controller' => 'modules', 'action' => 'delete', 'plugin' => false, $s['Module']['id']), array('escape' => false, 'class' => 'bs-tooltip trash', 'data-original-title' => 'Delete', 'data-alert-msg' => sprintf(__('Are you sure you want to delete module %s?'), $s['Module']['title']))); ?>
							</td>
						</tr>
						<?php $k = 1 - $k;
						} 
					}
					?>
					</tbody>
				</table>
				<?php echo $this->element('paginator');?>
			</div>
		</div>
	</div>
</div>