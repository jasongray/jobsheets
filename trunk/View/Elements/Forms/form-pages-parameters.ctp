<div class="tabbable box-tabs">
	<ul class="nav nav-tabs">
		<li><a href="#box_tab2" data-toggle="tab"><i class="icon-search"></i> <?php echo __('SEO');?></a></li>
		<li class="active"><a href="#box_tab1" data-toggle="tab"><i class="icon-tag"></i> <?php echo __('General');?></a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="box_tab1">
			<?php echo $this->Form->input('template', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Template'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'options' => $templates, 'empty' => '')); ?>
			<?php echo $this->Form->input('class', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Page Class'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>'));?>
			<?php $_author = empty($this->data['Page']['author'])? $this->Session->read('Auth.User.firstname') . ' ' . $this->Session->read('Auth.User.surname'): $this->data['Page']['author'];?>
			<?php echo $this->Form->input('author', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Author'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'value' => $_author)); ?>
			<div class="form-group">
				<label class="col-md-2 control-label"><?php echo __('Show Author');?></label>
				<div class="col-md-10">
					<?php echo $this->Form->input('show_author', array('div' => false, 'label' => false, 'class' => 'uniform', 'type' => 'checkbox')); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label"><?php echo __('Show Created Date');?></label>
				<div class="col-md-10">
					<?php echo $this->Form->input('show_created', array('div' => false, 'label' => false, 'class' => 'uniform', 'type' => 'checkbox')); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label"><?php echo __('Show Modified Date');?></label>
				<div class="col-md-10">
					<?php echo $this->Form->input('show_modified', array('div' => false, 'label' => false, 'class' => 'uniform', 'type' => 'checkbox')); ?>
				</div>
			</div>
			<?php $_date = empty($this->data['Page']['start_publish'])? date('d-m-Y'): $this->data['Page']['start_publish'];?>
			<?php echo $this->Form->input('start_publish', array('div' => 'form-group', 'class' => 'form-control datepicker', 'label' => array('text' => __('Start publish date'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'value' => $_date, 'type' => 'text'));?>
			<?php echo $this->Form->input('end_publish', array('div' => 'form-group', 'class' => 'form-control datepicker', 'label' => array('text' => __('End publish date'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'type' => 'text'));?>
		</div>
		<div class="tab-pane" id="box_tab2">
			<?php echo $this->Form->input('page_title', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Page Title'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>')); ?>
			<?php echo $this->Form->input('page_kw', array('div' => 'form-group', 'label' => array('text' => __('Page Keywords'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'type' => 'textarea', 'class' => 'form-control', 'rows' => 10));?>
			<?php echo $this->Form->input('page_meta', array('div' => 'form-group', 'label' => array('text' => __('Page Metadata'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'type' => 'textarea', 'class' => 'form-control', 'rows' => 10));?>
		</div>
	</div>
</div>