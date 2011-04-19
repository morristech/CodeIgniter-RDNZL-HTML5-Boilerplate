<h2>Blog Posts</h2>

<?php echo $this->parser->parse('blog/post_detail', array('posts' => $posts), true); ?>

<?php ?>
<script>
	document.write(unescape('%3Cscript src="<?php echo site_url("static/js/libs/jquery-ui-timepicker-addon.js");?>"%3E%3C/script%3E'))
	document.write(unescape('%3Cscript src="<?php echo site_url("static/js/libs/Icons.RDNZL.jquery.js");?>"%3E%3C/script%3E'))
	document.write(unescape('%3Cscript src="<?php echo site_url("static/js/libs/Input.RDNZL.jquery.js");?>"%3E%3C/script%3E'))
</script>

<script>
$(document).ready(function(){ 

	Icons.init();

	$('html.admin div.hentry').each(function(z, el){
		var $el = $(el);
		
		var $edit_trigger = Icons.$edit.clone()
			.css({'left':'-30px'})
			.click(function(){ $el.editItemSwapper() })
			
		var $save_trigger = Icons.$save.clone()
			.css({'left':'-30px','top':'30px'})
			.click(function(){ $el.saveItem() })
			
		$el
			.css({'position':'relative'})
			.append($edit_trigger)
			.append($save_trigger)
	});
	
	(function($){ $.fn.saveItem = function() {		
		var $el = $(this);
		var $form = $el.find('form');
		$form.submit();		
	}})(jQuery);

	
	(function($){ $.fn.editItemSwapper = function() {
		var $el = $(this);
		var editMode = ($el.hasClass('edit-mode')) ? true : false;
		
		// grab the fields show in normal context.
		// add your own here be sure to add them into the fieldsBeingShow array
		var $title = $el.find('.title')
		var $content = $el.find('.content')
		
		var fieldsBeingShown = new Array($title, $content);
		
		// the swapToEdit function
		var swapToEdit = function(){
			$.getJSON('<?php echo site_url(); ?>blog/get_post/' + $el.data('id'), function(data){
				// add class='edit-mode' to our container element (css hook)
				$el.addClass('edit-mode');
				$el.find('.ui-icon-pencil').removeClass('ui-icon-pencil').addClass('ui-icon-cancel');
				
				$.each(fieldsBeingShown, function(z, el){
					$(el).hide();
				});
				
				var $form = $('<form method="post" action="<?php echo site_url(); ?>blog/update_post/' + $el.data('id') + '"/>')
					.append(Input.$text.clone().attr({'name':'title'}).val(data.title)) // title field
					.append(Input.$textbox.clone().attr({'name':'content'}).text(data.content)) // post content field
					.appendTo($el)
					.submit(function(e){
						e.preventDefault();
						var data = {
							ajax: true,
							title: $('input[name=title]', $el).val(),
							content: $('textarea[name=content]', $el).val()
						}
						$.post('<?php echo site_url(); ?>blog/update_post/' + $el.data('id'), data, function(data){
							swapToView();
						}, 'json');
						return false;
					})
			});
		}
		
		// and the swapToView function
		var swapToView = function(){
			$el.find('form').hide();
			$.getJSON('<?php echo site_url(); ?>blog/get_post/' + $el.data('id'), function(data){
				var foo = 0;
				$el.removeClass('edit-mode');
				$el.find('.ui-icon-cancel').removeClass('ui-icon-cancel').addClass('ui-icon-pencil');
				$title.text(data.title);
				$content.text(data.content);
				
				$.each(([$title,$content]),function(z, el){
					$(el).show();
				});
				
			});
			
		}
		
		// now that we've defined our variables and stuff, DO something, eh?
		if(!editMode){
			swapToEdit();
		} else {
			swapToView();
		}
	}})(jQuery);
	
});

</script>