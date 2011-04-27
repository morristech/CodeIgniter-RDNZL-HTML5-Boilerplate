<h2>Site Users</h2>

<?php echo $this->parser->parse('auth/admin/user_detail', array('users' => $users), true); ?>

<?php ?>
<script>
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
		<?php if(isset($el->options) && count($el->options) > 0): ?>
			, field_options: <?php echo json_encode($el->options); ?>
		<?php endif; ?>
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
			create:'/auth/create_user/',
			read:'/auth/get_user/',
			update:'/auth/update_user/',
			del:'/auth/delete_user/',
			fetchAll:'/auth/get_users/' // not sure we'll use this
		}
	}
	$('html.admin div.hentry').each(function(z, el){
		$(el).attachAdmin(options)
	})
})

</script>