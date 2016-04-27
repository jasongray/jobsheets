<div class="row">
<?php if($params['show_title'] || (isset($p) && !empty($p['Page']['show_title'])))  { ?>
<div class="post_header">
	<?php $title = $params['show_title']? $params['page_title']: $p['Page']['title'];?>
	<?php echo $this->Html->tag('h1', $title);?>
	<span class="title_divider"></span>
</div>
<?php } ?>
<iframe src="<?php echo $m['link'];?>" width="100%" height="<?php echo $m['height'];?>" class="module_frame <?php echo $m['class'];?>" scrolling="no" frameborder="0" sandbox></iframe>
</div>
<?php echo $this->Html->scriptBlock("
$(document).ready(function(){
	var iframe = $('.module_frame').contents();
	if ($('.module_frame').height == 0){
		$(this).load(function() {
			this.style.height = this.contentWindow.document.body.offsetHeight + 'px';
		});
	}
});
", array('inline' => false));?>