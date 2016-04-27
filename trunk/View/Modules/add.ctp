<?php $this->Html->pageClass = 'modules';?>
<?php $this->Html->pageTitle = __('Add Module');?>
<?php $this->Html->addCrumb(__('Modules'), array('controller' => 'modules', 'action' => 'index', 'plugin' => false));?>
<?php $this->Html->addCrumb(__('Add Module'));?>

<?php echo $this->Form->create('Module', array('class' => 'form-horizontal row-border'));?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-folder"></i> <?php echo __('Select Module', true);?></h4>
			</div>
			<div class="panel-body">
				<div class="form-horizontal row-border">
					<?php echo $this->Form->input('module_file', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Module'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'options' => $module_files, 'empty' => '')); ?>
					<?php echo $this->Form->input('position', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Position'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'options' => $positions, 'empty' => '')); ?>
					<div class="panel-footer">
						<div class="row">
							<div class="col-md-6 col-sm-offset-2">
								<?php
									echo $this->Form->hidden('id');
									echo $this->Form->submit('Next', array('class'=>'btn btn-primary', 'div' => false)); 
									echo $this->Html->link('Cancel', array('controller' => 'modules', 'action' => 'cancel', 'plugin' => false), array('class' => 'btn btn-default'));
								?>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>