<?php echo $this->Form->create('User', array('class'=>'form-horizontal register'));?>
<div class="panel-body">
	<h4 class="text-center" style="margin-bottom: 25px;"><?php echo __('Create your new password');?></h4>
	<?php echo $this->Flash->render('auth');?><?php echo $this->Flash->render();?>
	<div class="form-group userpass">
		<div class="col-sm-12">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<?php echo $this->Form->input('password', array('div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => __('New Password (min 6 characters)'), 'autofocus' => 'autofocus', 'data-minlength' => 6));?>
	    	</div>
	    </div>
	</div>
	<div class="form-group confirmpass">
		<div class="col-sm-12">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<?php echo $this->Form->input('cpassword', array('div' => false, 'label' => false, 'type' => 'password', 'class' => 'form-control', 'placeholder' => __('Confirm Password'), 'autofocus' => 'autofocus'));?>
	    	</div>
	    </div>
	</div>
	<div class="alert alert-info">
		<div class="row">
			<div class="col-xs-2">
				<strong><i class="fa fa-warning fa-3x"></i></strong>
			</div>
			<div class="col-xs-10">
				<p><?php echo __('It is always best to create a password using a combination of lower and uppercase letters, numbers and symbols.');?></p>
			</div>
		</div>
	</div>
</div>
<div class="panel-footer">
	<div class="pull-left">
		
	</div>
	<div class="pull-right">
		<?php echo $this->Form->hidden('resetcode', array('value' => $this->request->params['pass'][0]));?>
    	<?php echo $this->Form->submit(__('Save'), array('class' => 'btn btn-primary', 'escape' => false));?>
    </div>
</div>
<?php echo $this->Form->end();?>
<?php echo $this->Html->script(array('jquery-3.1.0.min', 'user.reset'), array('inline' => false));?>