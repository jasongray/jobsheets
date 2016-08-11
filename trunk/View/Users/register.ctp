<?php echo $this->Form->create('User', array('class'=>'form-horizontal register'));?>
<div class="panel-body">
	<h4 class="text-center" style="margin-bottom: 25px;"><?php echo __('Register for a free trial');?></h4>
	<?php echo $this->Flash->render('auth');?><?php echo $this->Flash->render();?>
	<div class="form-group">
		<div class="col-sm-12">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-user"></i></span>
				<?php echo $this->Form->input('email', array('div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => __('Your Email'), 'autofocus' => 'autofocus'));?>
	    	</div>
	    </div>
	</div>
	<div class="form-group">
		<div class="col-sm-12">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-building"></i></span>
				<?php echo $this->Form->input('business', array('div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => __('Company Name')));?>
	    	</div>
	    </div>
	</div>
	<div class="form-group">
		<div class="col-sm-12">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-phone"></i></span>
				<?php echo $this->Form->input('phone', array('div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => __('Mobile')));?>				
	    	</div>
	    	<div class="help-block"><?php echo __('We will send you a verification code to this number.');?></div>
	    </div>
	</div>
	<div class="form-group">
		<div class="col-sm-12">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-globe"></i></span>
				<?php echo $this->Form->input('locale', array('div' => false, 'label' => false, 'class' => 'form-control select2', 'placeholder' => __('Select Location'), 'empty' => ''));?>
	    	</div>
	    </div>
	</div>
</div>
<div class="panel-footer">
	<div class="pull-left">
		<?php echo $this->Html->link(__('Back'), array('controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-default', 'escape' => false));?>
	</div>
	<div class="pull-right">
    	<?php echo $this->Form->button(__('Register'), array('class' => 'btn btn-primary', 'escape' => false));?>
    </div>
</div>
<?php echo $this->Form->end();?>
<?php echo $this->Html->css(array('plugins/select2.min.css'), array('inline' => false));?>
<?php echo $this->Html->script(array('jquery-3.1.0.min', 'bootstrap.min', 'plugins/select2/select2.min.js'), array('inline' => false));?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function() {
    $('.select2').select2();

});", array('inline' => false));?>