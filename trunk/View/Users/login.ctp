<?php echo $this->Form->create('User', array('class'=>'form-horizontal'));?>
<div class="panel-body">
	<h4 class="text-center" style="margin-bottom: 25px;"><?php echo __('Log in to start using JobSheets');?></h4>
	<?php echo $this->Flash->render('auth');?><?php echo $this->Flash->render();?>
	<div class="form-group">
		<div class="col-sm-12">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-user"></i></span>
				<?php echo $this->Form->input('email', array('div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => __('Username / Email'), 'autofocus' => 'autofocus'));?>
	    	</div>
	    </div>
	</div>
	<div class="form-group">
		<div class="col-sm-12">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<?php echo $this->Form->input('password', array('div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => __('Password')));?>
	    	</div>
	    </div>
	</div>
</div>
<div class="panel-footer">
	<div class="pull-left">
		<?php echo $this->Html->link(__('Register'), array('controller' => 'users', 'action' => 'register'), array('class' => 'btn btn-default', 'escape' => false));?>
	</div>
	<div class="pull-right">
    	<?php echo $this->Form->button(__('Log In'), array('class' => 'btn btn-primary', 'escape' => false));?>
    </div>
</div>
<?php echo $this->Form->end();?>