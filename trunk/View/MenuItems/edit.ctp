<?php $this->Html->pageClass = 'menu';?>
<?php $this->Html->pageTitle = __('Manage Menus');?>
<?php $this->Html->addCrumb(__('Menus'), array('controller' => 'menus', 'action' => 'index'));?>
<?php $this->Html->addCrumb($menu_title, array('controller' => 'menusItems', 'action' => 'index', 'menu_id' => $this->passedArgs['menu_id']));?>
<?php $this->Html->addCrumb(__('Edit Menu Item'));?>
<?php echo $this->Form->create('MenuItem');?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Edit Menu Item');?></h4>
			</div>
			<div class="panel-body">
				<div class="form-horizontal row-border">
				<?php echo $this->element('Forms/form-menuitems');?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-cog"></i> <?php echo __('Parameters');?></h4>
			</div>
			<div class="panel-body">
				<div class="form-horizontal row-border">
				<?php echo $this->element('Forms/form-menuitems-parameters');?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>