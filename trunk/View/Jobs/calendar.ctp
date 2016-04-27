<?php $this->Html->pageClass = 'calendar';?>
<?php $this->Html->pageTitle = __('Job Calendar');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php $this->Html->addCrumb(__('Job Calendar'));?>
<?php echo $this->Html->css(array('fullcalendar'), array('inline' => false));?>
<?php $events = json_encode(array());?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h4><i class="fa fa-calendar"></i> <?php echo __('Calendar', true);?></h4>
				
			</div>
			<div class="panel-body">
				<div id="calendar-wrap">
					<?php if (!empty($data)) {
						$events = array();
						foreach ($data as $e) {
							if (empty($e['Job']['finishby'])) {
								$e['Job']['finishby'] = date('Y-m-d\TH:i:s', strtotime($e['Job']['allocated']) + 60*60);
							}
							$events[] = array(
								'id' => $e['Job']['reference'], 
								'start' => date('Y-m-d\TH:i:s', strtotime($e['Job']['allocated'])), 
								'end' => $e['Job']['finishby'],
								'title' => $e['Job']['title'],
							);
						}
						$events = json_encode($events);
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script(array('plugins/fullcalendar/fullcalendar.min'), array('inline' => false));?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function() {
	var calendar = $('#calendar-wrap').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultView: 'agendaWeek',
		eventLimit: true,
		buttonText: {
			prev: '<i class=\"fa fa-angle-left\"></i>',
			next: '<i class=\"fa fa-angle-right\"></i>',
			prevYear: '<i class=\"fa fa-angle-double-left\"></i>',  // <<
			nextYear: '<i class=\"fa fa-angle-double-right\"></i>',  // >>
			today:    '".__('Today')."',
			month:    '".__('Month')."',
			week:     '".__('Week')."',
			day:      '".__('Day')."'
		},
		titleFormat: {
			month: 'MMMM yyyy',
			week: \"d MMM [ yyyy]{ '&#8212;' d MMM yyyy}\",
			day: 'dddd, MMM d, yyyy'
		},
		columnFormat: {
			month: 'ddd',
			week: 'ddd d/M',
			day: 'dddd d/M'
		},
		events: ".$events.",
	});
});", array('inline' => false));?>