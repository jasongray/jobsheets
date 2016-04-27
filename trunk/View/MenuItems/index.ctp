<?php $this->Html->pageClass = 'menus';?>
<?php $this->Html->pageTitle = __('Menu Manager');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Menus'), array('controller' => 'menus', 'action' => 'index'));?>
<?php $this->Html->addCrumb($menu_title);?>
<?php echo $this->Html->css(array('datatables'), array('inline' => false));?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo $menu_title;?></h4>
				
			</div>
			<div class="panel-body">
				<?php echo $this->Html->link('Add Item', array('action' => 'add', 'menu_id' => $this->passedArgs['menu_id']), array('class'=>'btn btn-success', 'escape' => false))?>
				<table cellpadding="0" cellspacing="0" class="table table-hover table-striped">
					<thead>
					<tr>
						<th class="icon"><?php echo __('Id');?></th>
						<th><?php echo __('Menu Item');?></th>
						<th colspan="2"><?php echo __('Ordering');?></th>
						<th class="icon"><?php echo  __('Published');?></th>
						<th class="actions"><?php __('Actions');?></th>
					</tr>
					</thead>
					<tbody>
					<?php $pt = 0;?>
					<?php for($i=0;$i<count($data);$i++){ 
						$mi = $data[$i]; ?>
					<tr>
						<td><?php echo $this->Html->link($mi['MenuItem']['id'], array('action' => 'edit', $mi['MenuItem']['id'], 'menu_id' => $this->passedArgs['menu_id']), array('class'=>'edit-link'));?></td>
						<td><?php echo $this->Html->link($mi['MenuItem']['treename'], array('action' => 'edit', $mi['MenuItem']['id'], 'menu_id' => $this->passedArgs['menu_id']), array('escape' => false)); ?></td>
						
						<td><?php echo $this->Html->link('<i class="fa fa-arrow-up"></i>', array('action' => 'orderup', $mi['MenuItem']['id'], 'menu_id' => $this->passedArgs['menu_id']), array('escape'=>false));?></td>
						<td><?php echo $this->Html->link('<i class="fa fa-arrow-down"></i>', array('action' => 'orderdown', $mi['MenuItem']['id'], 'menu_id' => $this->passedArgs['menu_id']), array('escape'=>false));?></td>
						
						<td><?php if ($mi['MenuItem']['published'] == 1){ echo '<span class="label label-success">'.__('Published').'</span>'; } else { '<span class="label label-warning">'.__('Unpublished').'</span>';} ?></td>
						
						
						<td class="actions">
							<?php echo $this->Html->link('<i class="fa fa-pencil"></i>', array('action' => 'edit', $mi['MenuItem']['id'], 'menu_id' => $this->passedArgs['menu_id']), array('escape' => false, 'class' => 'bs-tooltip', 'data-original-title' => 'Edit')); ?>
							<?php echo $this->Html->link('<i class="fa fa-trash"></i>', array('action' => 'delete', $mi['MenuItem']['id'], 'menu_id' => $this->passedArgs['menu_id']), array('escape' => false, 'class' => 'bs-tooltip trash', 'data-original-title' => 'Delete', 'data-alert-msg' => sprintf(__('Are you sure you want to delete the %s menu item?'), $mi['MenuItem']['treename']))); ?>
						</td>
					</tr>
					<?php $pt = $mi['MenuItem']['parent_id'];?>
					<?php } ?>
					</tbody>
				</table>
				<?php //echo $this->element('paginator');?>
			</div>
		</div>
	</div>
</div>