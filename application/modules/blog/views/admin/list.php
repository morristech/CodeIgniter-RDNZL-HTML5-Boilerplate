<h2>Recent Blog Posts</h2>

<?php echo $this->parser->parse('blog/post_detail', array('posts' => $posts), true); ?>

<?php ?>
<script>
	document.write(unescape('%3Cscript src="<?php echo site_url("static/js/libs/jquery-ui-timepicker-addon.js");?>"%3E%3C/script%3E'))
	document.write(unescape('%3Cscript src="<?php echo site_url("static/js/libs/Icons.RDNZL.jquery.js");?>"%3E%3C/script%3E'))
	document.write(unescape('%3Cscript src="<?php echo site_url("static/js/libs/Input.RDNZL.jquery.js");?>"%3E%3C/script%3E'))
	document.write(unescape('%3Cscript src="<?php echo site_url("static/js/libs/admin-editor-addon.jquery.js");?>"%3E%3C/script%3E'))
</script>

<script>
var backEndElements = Array();
var frontEndElements = Array();

<?php foreach($backend_elements as $el): ?>
	backEndElements.push({
		field_name: '<?php echo $el->field_name; ?>',
		nice_name: '<?php echo $el->nice_name; ?>',
		field_type: '<?php echo $el->field_type; ?>'
	});
<?php endforeach; ?>

<?php foreach($frontend_elements as $el): ?>
	frontEndElements.push({
		field_name: '<?php echo $el->field_name; ?>',
		nice_name: '<?php echo $el->nice_name; ?>',
		field_type: '<?php echo $el->field_type; ?>'
	});
<?php endforeach; ?>

$(document).ready(function(){ 

	Icons.init();
	var options = {
		backEndElements:backEndElements,
		frontEndElements:frontEndElements,
		handlerURLs:{
			create:'/blog/create_post/',
			read:'/blog/get_post/',
			update:'/blog/update_post/',
			del:'/blog/delete_post/',
			fetchAll:'/blog/get_posts/' // not sure we'll use this
		}
	}
	$('html.admin div.hentry').each(function(z, el){
		$(el).attachAdmin(options)
	})
})

</script>