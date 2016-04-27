<div class="widget <?php echo $m['class'];?>">
	<?php if ($m['show_title'] == 1) { ?>
	<?php echo $this->Html->tag('h4', $m['title'], array('class' => 'widget_title'));?>
	<?php } ?>
	<?php echo $m['content'];?>
</div>