<?php echo $this->Form->create('User', array('class'=>'form-horizontal register'));?>
<div class="panel-body">
	<h4 class="text-center" style="margin-bottom: 25px;"><?php echo __('Reset your password');?></h4>
	<?php echo $this->Flash->render('auth');?><?php echo $this->Flash->render();?>
	<div class="form-group">
		<div class="col-sm-12">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-user"></i></span>
				<?php echo $this->Form->input('email', array('div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => __('Email Address'), 'autofocus' => 'autofocus'));?>
	    	</div>
	    </div>
	</div>
	<div class="well well-sm">
		<p>
			<strong><?php echo __('Security code');?></strong>
			<?php echo $this->Html->link('<i class="fa fa-refresh"></i>', array('controller' => 'users', 'action' => 'captcha'), array('class' => 'btn btn-sm btn-inverse pull-right', 'id' => 'captcha', 'escape' => false));?>
		</p>
		<div class="row">
			<div class="col-xs-5 c-wrapper">
	    		<?php echo $this->element('user-captcha');?>
	    	</div>
	    	<div class="col-xs-7">  
	    		<?php echo $this->Form->input('captcha', array('div' => false, 'label' => false, 'class' => 'form-control', 'placeholder' => __('Type the security code')));?>
	    	</div>
	    </div>
	</div>
</div>
<div class="panel-footer">
	<div class="pull-left">
		<?php echo $this->Html->link(__('Back'), array('controller' => 'users', 'action' => 'login'), array('class' => 'btn btn-default', 'escape' => false));?>
	</div>
	<div class="pull-right">
    	<?php echo $this->Form->submit(__('Reset'), array('class' => 'btn btn-primary', 'escape' => false));?>
    </div>
</div>
<?php echo $this->Form->end();?>
<?php echo $this->Html->script(array('jquery-1.10.2.min'), array('inline' => false));?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function(){
	$('#captcha').click(function(e){
		var url = $(this).attr('href');
		e.preventDefault();
		$('.c-wrapper').load(url);
	});
});", array('inline' => false));?>