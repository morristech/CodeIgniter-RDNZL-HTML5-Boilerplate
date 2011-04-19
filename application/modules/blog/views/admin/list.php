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
	
	(function($){ $.fn.attachAdmin = function() {		
		var $el = $(this)
			.css({'position':'relative'});
			
		// set up our 3 triggers: edit, save, and delete for all; (we'll do "add" separately, for the 1st one only
		var $edit_trigger = Icons.$edit.clone()
			.css({'left':'-30px'})
			.click(function(){ formActions.run() })
			
		var $save_trigger = Icons.$save.clone()
			.css({'left':'-30px','top':'30px'})
			.click(function(){ formActions.triggerSaveItem() })
		
		var $delete_trigger = Icons.$delete.clone()
			.css({'left':'-30px','top':'60px'})
			.click(function(){ formActions.deleteItem() })
			
		var formIcons = new Array($edit_trigger, $save_trigger, $delete_trigger);
		$.each(formIcons, function(z, $trigger_el){
			$trigger_el.hover(function(){$(this).addClass("ui-state-hover")},function(){$(this).removeClass("ui-state-hover")})
				.appendTo($el)
		})
		
		if($el.index()==1){
			var $add_trigger = Icons.$add.clone()
				.css({'left':'-30px','top':'-30px'})
				.click(function(){ formActions.insertNew() })
				.hover(function(){$(this).addClass("ui-state-hover")},function(){$(this).removeClass("ui-state-hover")})
				.appendTo($el)
		}
	
		var formActions = {
			id: $el.data('id'),
			data: {},
			editMode: function(){ return $el.hasClass('edit-mode') ? true : false},
			frontEndElements:{
				$title: $el.find('.title'),
				$content: $el.find('.content')
			},
			backEndElements:{},

			run:function(){
				var instance = this; // actions variable
				if(!instance.editMode()){
					instance.swapToEdit();
				} else {
					instance.swapToView();
				}
			},
			insertNew:function(){
				var instance = this;
				$new_el = $el.clone()
					.find('.title').empty().end()
					.find('.content').empty().end()
					.find('.datetime_published').empty().end()
				
				$form = instance.getEditForm()
					.submit(function(e){
						e.preventDefault();
						instance.assembleUserData()
						instance.saveItem()
					})
					.appendTo($new_el)
				
				$new_el.insertBefore($el)
			},
			swapToEdit: function(){
				var instance = this; // actions variable
				$.getJSON('<?php echo site_url(); ?>blog/get_post/' + instance.id, function(data){
					// add class='edit-mode' to our container element (css hook)
					instance.data = data;
					$el
						.addClass('edit-mode')
						.find('.ui-icon-pencil').removeClass('ui-icon-pencil').addClass('ui-icon-cancel')
						.end()
						.children(':not(.ui-icon-parent)').hide()
						
					var $form = instance.getEditForm()
						.submit(function(e){
							e.preventDefault();
							instance.assembleUserData()
							instance.saveItem()
						})
						.appendTo($el)
				})
			}, // end swapToEdit()
			assembleUserData: function(){
				var instance = this; // actions variable
				instance.data = {
					ajax: true,
					title: $('input[name=title]', $el).val(),
					content: $('textarea[name=content]', $el).val(),
					datetime_published: $('input[name=datetime_published]', $el).val()
				}
			},
			triggerSaveItem: function() {		
				var instance = this; // actions variable
				var $form = $el.find('form');
				$form.submit();		
			},
			saveItem:function(){
					
				var instance = this;
				// drop in a loading icon (to the left of the save-edit-trash column)
				var $loading = Icons.$loading.clone()
					.css({'left':'-60px'})
					.addClass('ui-state-default ui-corner-all ui-icon-parent')
					.appendTo($el)
				
				if(instance.id == 0){ // thios is our indicator that we're adding a new item
					// send the data to the server for update
					$.post('<?php echo site_url(); ?>blog/create_post/', instance.data, function(data){
						if(data.success){
							// swap back to "view" mode
							instance.swapToView();
						} else {
							// notify user that there was an error
						}
						// fade and remove the loading icon
						$loading.fadeOut('slow',function(){$loading.remove()});
					}, 'json');
				} else {
					// send the data to the server for update
					$.post('<?php echo site_url(); ?>blog/update_post/' + instance.id, instance.data, function(data){
						if(data.success){
							// swap back to "view" mode
							instance.swapToView();
						} else {
							// notify user that there was an error
						}
						// fade and remove the loading icon
						$loading.fadeOut('slow',function(){$loading.remove()});
					}, 'json');
				}
			}, // end saveEdit()
			
			deleteItem: function() {
				var instance = this;
				var confirmation = confirm('Are you sure you want to delete this post?');
				if(!confirmation) return;
				
				var $loading = Icons.$loading.clone()
					.css({'left':'-60px'})
					.addClass('ui-state-default ui-corner-all ui-icon-parent')
					.appendTo($el)
						
				$.post('<?php echo site_url(); ?>blog/delete_post/' + instance.id, function(data){
					if(data.success){
						$el.fadeOut('slow',function(){$el.remove()});
					} else {
						// notify user that there was an error
					}
				}, 'json');
			}, // end deleteItem()
			
			swapToView:function(){
				var instance = this; // actions variable
				// make our form disappear (and remove it!
				$el.find('form').css({'position':'absolute'}).hide().remove()
				
				// retrieve the item fresh from the server
				$.getJSON('<?php echo site_url(); ?>blog/get_post/' + instance.id, function(data){
					// remove the edit-mode class
					$el.removeClass('edit-mode')
					// change the cancel icon to a pencil icon (edit)
					$el.find('.ui-icon-cancel').removeClass('ui-icon-cancel').addClass('ui-icon-pencil')
					// populate the entry with the fresh data
					instance.frontEndElements.$title.text(data.title)
					instance.frontEndElements.$content.text(data.content)
					// iterate over the elements inside the entry and show them.
					$.each(instance.frontEndElements, function(z, $el){
						$el.show()
					})
					
				});
			}, // end swapToView()
			
			getEditForm: function(){
				var instance = this; // actions variable
				var $form = $('<form method="post" action=""/>')
					.append(Input.$text.clone().attr({'name':'title'}).val(instance.data.title)) // title field
					.append(Input.$textbox.clone().attr({'name':'content'}).text(instance.data.content)) // post content field
					.append(Input.$text.clone().attr({'name':'datetime_published'}).val(instance.data.datetime_published).datetimepicker({ dateFormat: 'yy-mm-dd' }))
					
				return $form
			} // end getEditForm()

					
		}// end actions
	}})(jQuery);
	
	$('html.admin div.hentry').each(function(z, el){
		$(el).attachAdmin()
	});
});

</script>