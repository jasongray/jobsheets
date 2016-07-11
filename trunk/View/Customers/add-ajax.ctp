<?php $this->Html->pageClass = 'customers';?>
<?php $this->Html->pageTitle = __('Create Customer');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Create Customer'));?>
<?php echo $this->Html->css(array('datatables'), array('inline' => false));?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-reorder"></i> <?php echo __('Create Customer', true);?></h4>
				
			</div>
			<div class="panel-body">
				<?php echo $this->Form->create('Customer', array('class' => 'wizard form-horizontal'));?>
					<?php echo $this->Form->input('name', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Customer Name')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
					<hr/>
					<?php echo $this->Form->input('property', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Property Name')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
					<?php echo $this->Form->input('unit', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Unit Number')), 'between' => '<div class="col-md-2">', 'after' => '</div>', 'div' => 'form-group'));?>
					<div class="form-group">
						<?php echo $this->Form->input('address_from', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 col-xs-2 control-label', 'text' => __('From')), 'between' => '<div class="col-md-2 col-xs-4">', 'after' => '</div>', 'div' => false));?>
						<?php echo $this->Form->input('address_to', array('class' => 'form-control', 'label' => array('class' => 'col-md-1 col-xs-2 control-label', 'text' => __('To')), 'between' => '<div class="col-md-2 col-xs-4">', 'after' => '</div>', 'div' => false));?>
					</div>
					<?php echo $this->Form->input('address_street', array('class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Street')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group'));?>
					<?php echo $this->Form->input('suburb', array('class' => 'form-control typeahead', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Suburb / Postcode')), 'between' => '<div class="col-md-6">', 'after' => '</div>', 'div' => 'form-group', 'data-provide' => 'typeahead', 'data-url' => $this->Html->url(array('controller' => 'postcodes', 'action' => 'get')), 'autocomplete' => 'off'));?>
                        <?php echo $this->Form->hidden('postcode_id');?>
				
				<?php echo $this->Form->submit(__('Add'), array('class' => 'btn btn-success', 'div' => false));?>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
</div>