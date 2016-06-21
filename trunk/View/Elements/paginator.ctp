<div class="row">
	<div class="col-md-6 hidden-xs">
		<?php echo $this->Paginator->counter(array('format' => __('Showing {:start} of {:end} of {:count} entries', true)));?>
	</div>
	<div class="col-md-6">
		<div class="dataTables_paginate">
			<ol class="pagination">
				<?php echo $this->Paginator->prev('<i class="fa fa-long-arrow-left"></i> ' . __('Prev'), array('tag' => 'li', 'escape' => false), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a', 'escape' => false));?>
				<?php echo $this->Paginator->numbers(array('tag' => 'li', 'class' => false, 'currentTag' => 'a', 'currentClass' => 'active', 'separator' => false, 'disabledTag' => 'a'));?>
				<?php echo $this->Paginator->next(__('Next') . ' <i class="fa fa-long-arrow-right"></i>', array('tag' => 'li', 'escape' => false), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a', 'escape' => false));?>
			</ol>
		</div>
	</div>
</div>