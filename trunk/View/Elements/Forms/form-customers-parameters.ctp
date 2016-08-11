<div class="tabbable box-tabs">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#customer_jobs" data-toggle="tab"><i class="fa fa-wrench"></i> <?php echo __('Jobs');?></a></li>
		<li><a href="#customer_quotes" data-toggle="tab"><i class="fa fa-hashtag"></i> <?php echo __('Quotes');?></a></li>
		<li><a href="#customer_note_log" data-toggle="tab"><i class="fa fa-search"></i> <?php echo __('Customer Log');?></a></li>
		
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="customer_jobs">
			<?php if (!empty($jobs)) { ?>
			<ul class="panel-tasks">
			<?php foreach($jobs as $j) { ?>
				<li class="item-primary">
					<label>
						<span class="item-description"><?php echo $this->Html->link($j['Job']['id'], array('controller' => 'jobs', 'action' => 'edit', $j['Job']['id']));?></span>
						<?php echo $this->Html->jobStatus($j['Job']['status']); ?>
					</label>
					<div class="options todooptions">
						<div class="btn-group">
							<?php echo $this->Html->link('<i class="fa fa-eye"></i>', array('controller' => 'jobs', 'action' => 'view', $j['Job']['id']), array('class' => 'btn btn-xs btn-default', 'escape' => false));?>
						</div>
					</div>
			<?php } ?>
			</ul>
			<?php } ?>
		</div>
		<div class="tab-pane" id="customer_quotes">
			<?php if (!empty($quotes)) { ?>
			<ul class="panel-tasks">
			<?php foreach($quotes as $q) { ?>
				<li class="item-success">
					<label>
						<span class="item-description"><?php echo $this->Html->link($q['Quote']['id'], array('controller' => 'quotes', 'action' => 'edit', $q['Quote']['id']));?></span>
						<?php echo $this->Html->jobStatus($q['Quote']['status']); ?>
					</label>
					<div class="options todooptions">
						<div class="btn-group">
							<?php echo $this->Html->link('<i class="fa fa-eye"></i>', array('controller' => 'quotes', 'action' => 'view', $q['Quote']['id']), array('class' => 'btn btn-xs btn-default', 'escape' => false));?>
						</div>
					</div>
			<?php } ?>
			</ul>
			<?php } ?>
		</div>
		<div class="tab-pane" id="customer_note_log">
			<?php echo $this->Form->create('CustomerNote', array('style' => 'padding-top:15px;', 'id' => 'CustomerNoteForm'));?>
				<?php echo $this->Form->input('CustomerNote.notes', array('div' => 'form-group', 'class' => 'form-control', 'label' => array('class' => 'col-md-2 control-label', 'text' => __('Customer Note')), 'between' => '<div class="col-md-7">', 'after' => '</div><div class="col-md-3">'.$this->Html->link(__('Add Note'), array('controller' => 'customers', 'action' => 'addnote'), array('class' => 'btn btn-sml btn-default btn-savenote')).'</div>', 'rows' => 4));?>
				<?php echo $this->Form->hidden('CustomerNote.client_id', array('value' => $this->Session->read('Auth.User.client_id')));?>
				<?php echo $this->Form->hidden('CustomerNote.client_meta', array('value' => $this->Session->read('Auth.User.client_meta')));?>
				<?php echo $this->Form->hidden('CustomerNote.user_id', array('value' => $this->Session->read('Auth.User.id')));?>
				<?php echo $this->Form->hidden('CustomerNote.customer_id', array('value' => $this->data['Customer']['id']));?>
			<?php echo $this->Form->end();?>
			<div id="threads">
				<?php if (!empty($this->data['CustomerNote'])) { ?>
				<ul class="panel-tasks">
				<?php foreach($this->data['CustomerNote'] as $cn) { ?>
					<li class="item">
						<label>
							<span class="task-description">
								<?php echo $cn['notes'];?>
							</span>
						</label>
						<span class="time">
							<i class="fa fa-clock-o"></i>
							<?php echo date('d F Y', strtotime($cn['created']));?>
						</span>
					</li>
				<?php } ?>
				</ul>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->scriptBlock("
$(document).ready(function($){
var saveNote = function() {
	$('#CustomerNoteForm .btn-savenote').click(function(e){
		e.preventDefault();
		$.post($(this).attr('href'), $('#CustomerNoteForm').serialize(), function(data){
			if(data.code == 200){
				$('#CustomerNoteNotes').val('');
				$('#customer_note_log #threads').load(window.location+' #threads >', function(){

				});
			}
		}, 'json');
    });
}
saveNote();
});", array('inline' => false));?>