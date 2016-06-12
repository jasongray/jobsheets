<?php $this->Html->pageClass = 'quotes';?>
<?php $this->Html->pageTitle = __('Add Quote Item');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Create Quote Item'));?>
<?php echo $this->Html->css(array('datatables'), array('inline' => false));?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Create Quote Item', true);?></h4>
				
			</div>
			<div class="panel-body">
				<?php echo $this->Form->create('QuoteItem', array('class' => 'form-horizontal'));?>
				<?php echo $this->Form->input('description', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Description')), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'div' => 'form-group'));?>
				<?php echo $this->Form->input('amount', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Amount')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group', 'data-inputmask' => "'mask':'$ 999,999.99', 'greedy' : false, 'rightAlignNumerics' : false", 'type' => 'text'));?>
				<?php echo $this->Form->hidden('quote_id', array('value' => $quote_id)); ?>

				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
</div>