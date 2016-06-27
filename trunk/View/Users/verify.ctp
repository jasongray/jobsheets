<?php echo $this->Form->create('User', array('class'=>'form-horizontal register'));?>
<div class="panel-body"><?php echo $this->Flash->render('auth');?><?php echo $this->Flash->render();?>
	<h4 class="text-center" style="margin-bottom: 25px;"><?php echo __('Enter your verification code');?></h4>
	<div class="form-group">
		<div class="col-sm-12">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<?php echo $this->Form->input('smscode', array('div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => __('Verification Code'), 'autofocus' => 'autofocus'));?>
	    	</div>
	    </div>
	</div>
</div>
<div class="panel-footer">
	<div class="pull-right">
    	<?php echo $this->Form->submit(__('Verify'), array('class' => 'btn btn-primary', 'escape' => false));?>
    </div>
</div>
<?php echo $this->Form->end();?>