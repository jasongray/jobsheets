<?php $this->Html->pageClass = 'menu';?>
<?php $this->Html->pageTitle = __('Manage Menus');?>
<?php $this->Html->addCrumb(__('Menus'), array('controller' => 'menus', 'action' => 'index'));?>
<?php $this->Html->addCrumb(__('Add Menu'));?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Add Menu');?></h4>
			</div>
			<div class="panel-body">
				<?php echo $this->element('Forms/form-menus');?>
			</div>
		</div>
	</div>
</div>