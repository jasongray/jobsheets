<?php $this->Html->pageClass = 'dashboard';?>
<?php $this->Html->pageTitle = __('My Dashboard');?>
<?php $this->Paginator->options(array('url' => $this->passedArgs)); ?>
<?php echo $this->Html->css(array('datatables', 'fullcalendar'), array('inline' => false));?>

<?php echo $this->start('heading');?>
<div class="options">
    <div class="btn-toolbar">
        <?php echo $this->Html->link('<i class="fa fa-cogs"></i> ' . __('My Account'), array('controller' => 'clients', 'action' => 'account'), array('class' => 'btn btn-inverse', 'escape' => false));?>
    </div>
</div>
<?php echo $this->end();?>

<?php echo $this->start('rightbar');?>
<div id="page-rightbar">

            <div tabindex="5003" style="max-height: 1507px; overflow-y: hidden;" id="widgetarea">
                <div class="widget">
                    <div class="widget-heading">
                        <a href="javascript:;" data-toggle="collapse" data-target="#accsummary"><h4>Account Summary</h4></a>
                    </div>
                    <div class="widget-body collapse in" id="accsummary">
                        <div class="widget-block" style="background: #595f69;">
                            <div class="pull-left">
                                <small>Account Type</small>
                                <h5>Business Plan A</h5>
                            </div>
                            <div class="pull-right">
                                <small class="text-right">Monthly</small>
                                <h5>$19<small>.99</small></h5>
                            </div>
                        </div>
                        <span class="more"><a href="#">Upgrade Account</a></span>
                    </div>
                </div>


                <div id="chatbar" class="widget">
                    <div class="widget-heading">
                        <a href="javascript:;" data-toggle="collapse" data-target="#chatbody"><h4>Online Contacts <small>(5)</small></h4></a>
                    </div>
                    <div class="widget-body collapse in" id="chatbody">
                        <ul class="chat-users">
                            <li data-stats="online"><a href="javascript:;"><img src="assets/demo/avatar/potter.png" alt=""><span>Jeremy Potter</span></a></li>
                            <li data-stats="online"><a href="javascript:;"><img src="assets/demo/avatar/tennant.png" alt=""><span>David Tennant</span></a></li>
                            <li data-stats="online"><a href="javascript:;"><img src="assets/demo/avatar/johansson.png" alt=""><span>Anna Johansson</span></a></li>
                            <li data-stats="offline"><a href="javascript:;"><img src="assets/demo/avatar/jackson.png" alt=""><span>Eric Jackson</span></a></li>
                            <li data-stats="away"><a href="javascript:;"><img src="assets/demo/avatar/jobs.png" alt=""><span>Howard Jobs</span></a></li>
                            <!--li data-stats="offline"><a href="javascript:;"><img src="assets/demo/avatar/watson.png" alt=""><span>Annie Watson</span></a></li>
                            <li data-stats="offline"><a href="javascript:;"><img src="assets/demo/avatar/doyle.png" alt=""><span>Alan Doyle</span></a></li>
                            <li data-stats="offline"><a href="javascript:;"><img src="assets/demo/avatar/corbett.png" alt=""><span>Simon Corbett</span></a></li>
                            <li data-stats="offline"><a href="javascript:;"><img src="assets/demo/avatar/paton.png" alt=""><span>Polly Paton</span></a></li-->
                        </ul>
                        <span class="more"><a href="#">See all</a></span>
                    </div>
                </div>

                <div class="widget">
                    <div class="widget-heading">
                        <a href="javascript:;" data-toggle="collapse" data-target="#storagespace"><h4>Storage Space</h4></a>
                    </div>
                    <div class="widget-body collapse in" id="storagespace">
                        <div class="clearfix" style="margin-bottom: 5px;margin-top:10px;">
                            <div class="progress-title pull-left">1.31 GB of 1.50 GB used</div>
                            <div class="progress-percentage pull-right">87.3%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" style="width: 50%"></div>
                            <div class="progress-bar progress-bar-warning" style="width: 25%"></div>
                            <div class="progress-bar progress-bar-danger" style="width: 12.3%"></div>
                        </div>
                    </div>
                </div>

                <div class="widget">
                    <div class="widget-heading">
                        <a href="javascript:;" data-toggle="collapse" data-target="#serverstatus"><h4>Server Status</h4></a>
                    </div>
                    <div class="widget-body collapse in" id="serverstatus">
                        <div class="clearfix" style="padding: 10px 24px;">
                            <div class="pull-left">
                                <div class="easypiechart" id="serverload" data-percent="67">
                                        <span class="percent">67</span>
                                <canvas width="90" height="90"></canvas></div>
                                <label for="serverload">Load</label>
                            </div>
                            <div class="pull-right">
                                <div class="easypiechart" id="ramusage" data-percent="20.6">
                                    <span class="percent">21</span>
                                <canvas width="90" height="90"></canvas></div>
                                <label for="ramusage">RAM: 422MB</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
<?php echo $this->end();?>

<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-3 col-xs-12 col-sm-6">
				<a class="info-tiles tiles-primary" href="<?php echo $this->Html->url(array('controller' => 'invoices', 'action' => 'index'));?>">
					<div class="tiles-heading"><?php echo __('Invoices');?></div>
					<div class="tiles-body-alt">
						<div class="text-center">
							<span class="text-top">$</span><?php echo substr($this->Number->currency($invoice['total'], 'AUD'), 1);?>
						</div>
						<small><?php echo $this->Number->toPercentage($invoice['lastweek'], 1);?> <?php echo __('from last week');?></small>
					</div>
					<div class="tiles-footer"><?php echo __('go to accounts');?></div>
				</a>
			</div>
			<div class="col-md-3 col-xs-12 col-sm-6">
				<a class="info-tiles tiles-orange" href="<?php echo $this->Html->url(array('controller' => 'jobs', 'action' => 'index'));?>">
					<div class="tiles-heading"><?php echo __('Jobs');?></div>
					<div class="tiles-body-alt">
						<i class="fa fa-wrench"></i>
						<div class="text-center"><?php echo $jobs['outstanding'];?></div>
						<small><?php echo __('current outstanding jobs');?></small>
					</div>
					<div class="tiles-footer"><?php echo __('manage jobs');?></div>
				</a>
			</div>
			<div class="col-md-3 col-xs-12 col-sm-6">
				<a class="info-tiles tiles-inverse" href="<?php echo $this->Html->url(array('controller' => 'quotes', 'action' => 'index'));?>">
					<div class="tiles-heading"><?php echo __('Quotes');?></div>
					<div class="tiles-body-alt">
						<i class="fa fa-hashtag"></i>
						<div class="text-center"><?php echo $quotes['count'];?></div>
						<small><?php echo __('current quotes');?></small>
					</div>
					<div class="tiles-footer"><?php echo __('manage quotes');?></div>
				</a>
			</div>
			<div class="col-md-3 col-xs-12 col-sm-6">
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h4><i class="fa fa-calendar"></i> <?php echo __('Job Calendar', true);?></h4>
			</div>
			<div class="panel-body">
				<div id="calendar-wrap">
					<?php $events = json_encode(array());?>
					<?php if (!empty($calendar)) {
						$events = array();
						foreach ($calendar as $e) {
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
<?php echo $this->Html->script(array('plugins/fullcalendar/fullcalendar.min'), array('inline' => false));?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function() {
	var calendar = $('#calendar-wrap').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultView: 'month',
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
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-midnightblue">
			<div class="panel-heading">
				<h4><i class="fa fa-calendar"></i> <?php echo __('System Messages', true);?></h4>
			</div>
			<div class="panel-body">
				<div id="threads">
					<?php if (!empty($messages)) { ?>
					<ul class="panel-tasks">
					<?php foreach ($messages as $m) { ?>
						<li class="item-<?php echo $m['Sysmsg']['label'];?>">
							<?php echo $this->Resize->image('users/'.$m['User']['avatar'], 35, 35, false, array());?>
							<label>
								<span class="task-description"><?php echo $m['Sysmsg']['message'];?></span>
							</label>
							<span class="time"><?php echo $this->Time->timeAgoInWords($m['Sysmsg']['created']);?></span>
						</li>
					<?php } ?>
					</ul>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>