<?php echo $this->Form->input('params.menu_id', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Menu'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>', 'empty' => '', 'options' => $helper->getMenus()));?>
<?php echo $this->Form->input('params.dropclassli', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Sub menu list class'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>'));?>
<?php echo $this->Form->input('params.dropclassul', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Sub menu class'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>'));?>
<?php echo $this->Form->input('params.selected', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('text' => __('Selected class'), 'class' => 'col-md-2 control-label'), 'between' => '<div class="col-md-10">', 'after' => '</div>'));?>