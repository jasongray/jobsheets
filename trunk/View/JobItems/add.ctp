<?php $this->Html->pageClass = 'jobs';?>
<?php $this->Html->pageTitle = __('Add Job Item');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Create Job Item'));?>
<?php echo $this->Html->css(array('datatables'), array('inline' => false));?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Create Job Item', true);?></h4>
				
			</div>
			<div class="panel-body">
				<?php echo $this->Form->create('JobItem', array('class' => 'form-horizontal'));?>
				<?php echo $this->Form->input('description', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Description')), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'div' => 'form-group'));?>
				<?php echo $this->Form->input('status', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Status')), 'between' => '<div class="col-md-8">', 'after' => '</div>', 'div' => 'form-group', 'empty' => '', 'options' => array(__('Unallocated'), __('Allocated'), __('Tasked'), __('Draft'), 8 => __('Completed'), 9 => __('Cancelled'))));?>
				<?php echo $this->Form->input('amount', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Amount')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group', 'data-inputmask' => "'mask':'$ 999,999.99', 'greedy' : false, 'rightAlignNumerics' : false", 'type' => 'text'));?>
				<?php echo $this->Form->hidden('job_id', array('value' => $job_id)); ?>

				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
</div>