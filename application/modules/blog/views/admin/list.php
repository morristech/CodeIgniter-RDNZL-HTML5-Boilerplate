<h2>Blog Posts</h2>

<?php echo $this->parser->parse('blog/post_detail', array('posts' => $posts), true); ?>

<script>
$(document).ready(function(){ 

	$('html.admin div.hentry').each(function(z, el){
		var $el = $(el);
		
		var $edit_trigger = Icons.$edit.clone()
			.css({
				'position':'absolute',
				'top':'0px',
				'left':'-30px'
			})
			.click(function(){ $el.editItemSwapper() })
			
		var $save_trigger = Icons.$save.clone()
			.css({
				'position':'absolute',
				'top':'30px',
				'left':'-30px'
			})
			.click(function(){ 
				$el.saveItem() 
			})
			
		$el
			.css({'position':'relative'})
			.append($edit_trigger)
			.append($save_trigger)
			
		
	});
	
	(function($){ $.fn.saveItem = function() {		
		var $el = $(this);
		
		var $form = $el.find('form');
		
		var foo = 0;
		
		$form.submit();
		
	}})(jQuery);

	
	(function($){ $.fn.editItemSwapper = function() {
		var $el = $(this);
		var editMode = ($el.hasClass('edit-mode')) ? true : false;
		var $title = $el.find('.title')
		var $content = $el.find('.post-content')
		
		var swapToEdit = function(){
			$.getJSON('<?php echo site_url(); ?>blog/ajax/get_post/' + $el.data('id'), function(data){
				var foo = 0;
				$el.addClass('edit-mode');
				$.each(([$title,$content]),function(z, el){
					$(el).hide();
				});
				var $form = $('<form method="post" action="<?php echo site_url(); ?>blog/ajax/update_post/' + $el.data('id') + '"/>')
					.append(Input.$text.clone().attr({'name':'title'}).val(data.title)) // out title field
					.append(Input.$textbox.clone().attr({'name':'content'}).text(data.content)) // out post content field
					.appendTo($el)
					.submit(function(e){
						e.preventDefault();
						var data = {
							title: $('input[name=title]', $el).val(),
							content: $('textarea[name=content]', $el).val()
						}
						$.post('<?php echo site_url(); ?>blog/ajax/update_post/' + $el.data('id'), data, function(data){
							alert('updated!');
							swapToView();
						}, 'json');
						return false;
					})
			});
		}
		
		var swapToView = function(){
			$el.find('form').hide();
			$.getJSON('<?php echo site_url(); ?>blog/ajax/get_post/' + $el.data('id'), function(data){
				var foo = 0;
				$el.removeClass('edit-mode');
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

var Icons = {
	$edit: $('<a href="#" class="ui-state-default ui-corner-all ui-icon-parent edit-trigger"><span class="ui-icon ui-icon-pencil"/></a>'),
	$save: $('<a href="#" class="ui-state-default ui-corner-all ui-icon-parent save-trigger"><span class="ui-icon ui-icon-disk"/></a>'),
	init:function(){
		var instance = this;
		var icons = new Array([instance.$edit, instance.$save])
		$.each( icons, function(z,el){
			$(el).hover(
				function(){ $(el).addClass("ui-state-hover") },
				function(){ $(el).removeClass("ui-state-hover") }
			)			
		});
	}
}

var Input = {
	$text: $('<input type="text"/>').addClass('text-input'),
	$textbox: $('<textarea rows="4" cols="60"/>').addClass('text-input textbox')
}

</script>

