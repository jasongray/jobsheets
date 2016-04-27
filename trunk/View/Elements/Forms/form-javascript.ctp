<?php $mytheme = Configure::read('MySite.theme');?>
<?php $theme = (!empty($mytheme))? APP.'View'.DS.'Themed'.DS.Configure::read('MySite.theme').DS.WEBROOT_DIR.DS.'img'.DS.'media': APP.WEBROOT_DIR.DS.'img'.DS.'media';?>
<?php echo $this->Html->script(array(
	'plugins/typeahead/typeahead.min.js', 
	'plugins/autosize/jquery.autosize.min.js', 
	'plugins/uniform/jquery.uniform.min.js',
	'plugins/tagsinput/jquery.tagsinput.min.js',
	'plugins/tinymce/tinymce.min',
	'plugins/tinymce/jquery.tinymce.min',
), array('inline' => false));?>
<?php echo $this->Html->scriptBlock("
$(document).ready(function(){
	$('textarea.wysiwyg').tinymce({
		plugins: [
        	\"advlist autolink lists link image charmap print preview anchor\",
        	\"searchreplace visualblocks code fullscreen textcolor colorpicker textpattern\",
        	\"insertdatetime media table contextmenu paste moxiemanager\"
	    ],
	    toolbar1: \"undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent\",
	    toolbar2: \"preview link image insertfile media | forecolor textpattern code\",
	    relative_urls: false,
	    remove_script_host: false,
	    schema: 'html5',
	    extended_valid_elements : 'i[class],script[type]',

	});
	if ($('.tags-autocomplete').length > 0) {
		$('.tags-autocomplete').tagsInput({
			width: '100%',
			height: 'auto',
			autocomplete_url: '{$this->Html->url(array('controller' => 'tags', 'action' => 'get', 'admin' => false, 'plugin' => false))}'
		});
	}
	if ($('.datepicker').length > 0) {
		$('.datepicker').datepicker({
			showOtherMonths:true,
			autoSize: true,
			appendText: '<span class=\"help-block\">(dd-mm-yyyy)</span>',
			dateFormat: 'dd-mm-yy'
		});
	}
	var tinymcetheme = '".urlencode($theme)."';
});
" , array('inline' => false));?>