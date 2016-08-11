<div class="tabbable box-tabs">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#customer_job_quotes" data-toggle="tab"><i class="icon-tag"></i> <?php echo __('Jobs & Quotes');?></a></li>
		<li><a href="#customer_note_log" data-toggle="tab"><i class="icon-search"></i> <?php echo __('Customer Log');?></a></li>
		
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="customer_job_quotes">
			
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