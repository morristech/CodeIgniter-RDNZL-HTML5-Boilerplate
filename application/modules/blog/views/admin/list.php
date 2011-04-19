<h2>Recent Blog Posts</h2>

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
	
	(function($){ $.fn.attachAdmin = function(options) {
		if(!options){
			options = {}
		} else{
			if(!options.run){
				options.run = false
			}
		}
		var $el = $(this)
			.css({'position':'relative'})
			
		// set up our triggers: add, edit, save, and delete
		var $add_trigger = Icons.$add.clone()
			.css({'left':'-30px','top':'30px'})
			.click(function(){ formActions.insertNew() })
			
		var $edit_trigger = Icons.$edit.clone()
			.css({'left':'-30px'})
			.click(function(){ formActions.run() })
			
		var $save_trigger = Icons.$save.clone()
			.css({'left':'-60px','top':'00px'})
			.click(function(){ formActions.triggerSaveItem() })
		
		var $delete_trigger = Icons.$delete.clone()
			.css({'left':'-60px','top':'30px'})
			.click(function(){ formActions.deleteItem() })
			
		var formIcons = new Array($edit_trigger, $save_trigger, $delete_trigger, $add_trigger)
		$.each(formIcons, function(z, $trigger_el){
			$trigger_el.hover(function(){$(this).addClass("ui-state-hover")},function(){$(this).removeClass("ui-state-hover")})
				.appendTo($el)
		})
				
		var formActions = {
			id: $el.data('id'),
			data: {
				'title':'',
				'content':'',
				'datetime_published':'',
			},
			
			// modify these two blocks to include field names for frontend...
			frontEndElements: Array(
				[{field_name:'title', nice_name:'Title', field_type: 'text'}],
				[{field_name:'content', nice_name:'Content', field_type: 'textbox'}]
			),
			// ... and backend elements
			backEndElements: Array(
				[{field_name:'title', nice_name:'Title', field_type: 'text'}],
				[{field_name:'content', nice_name:'Content', field_type: 'textbox'}],
				[{field_name:'datetime_published', nice_name:'Publish Date', field_type: 'text'}]
			),
			// end of edits to make this run on ANY form (hah in theory anways!! :)
			
			setupDataProperty:function(){
				$.each(instance.backEndElements, function(z, el_data){ el_data = el_data[0]
					instance.data[el_data.field_name] = ''
				})
			},
			run:function(){
				var instance = this // actions variable
				if(!instance.editMode()){
					instance.swapToEdit()
				} else {
					instance.swapToView()
				}
			},
			
			editMode: function(){ return $el.hasClass('edit-mode') ? true : false},
			
			notifyError:function(msg){
				var instance = this
				var dialogOptions = { modal: true, resizable: false, draggable: false, dialogClass: 'widget-error-msg' }				
				var $div = $('<div title="Error"/>')
					.appendTo($el)
					.html(msg)
					.dialog(dialogOptions)					
					
					var foo = 0
			},
			
			insertNew:function(){
				var instance = this
				var $new_el = $el.clone()
				$new_el
					.attr({'id':'item-0','data-id':'0'})
					.find('.ui-icon-parent').remove()
					.find('form').remove()
					
				$new_el.attachAdmin({run:true})
				
				$new_el.insertBefore($el)
			},
			
			swapToEdit: function(){
				var instance = this // actions variable
				var setupEl = function(){
					$el
						.addClass('edit-mode')
						.find('.ui-icon-pencil').removeClass('ui-icon-pencil').addClass('ui-icon-cancel')
						.end()
						.children(':not(.ui-icon-parent)').hide()
				}
				var setupForm = function(){
					var $form = instance.getEditForm()
						.submit(function(e){
							e.preventDefault()
							instance.assembleUserData()
							instance.saveItem()
						})
						.appendTo($el)
				}
				if(instance.id != 0){
					$.getJSON('<?php echo site_url() ?>blog/get_post/' + instance.id, function(data){
						// add class='edit-mode' to our container element (css hook)
						instance.data = data
						setupEl()
						setupForm()						
					})
				} else {
					setupEl()
					setupForm()
				}
			}, // end swapToEdit()
			
			assembleUserData: function(){
				var instance = this // actions variable
				instance.data = {ajax:true}
				
				$.each(instance.backEndElements, function(z,el_data){el_data = el_data[0]
					var tag
					if(el_data.field_type == 'text'){
						tag = 'input'
					} else {
						tag = 'textarea'
					}
							
					instance.data[el_data.field_name] = $(tag + '[name=' + el_data.field_name + ']', $el).val()
				})
			},
			
			triggerSaveItem: function() {		
				var instance = this // actions variable
				var $form = $el.find('form')
				$form.submit()		
			},
			saveItem:function(){
					
				var instance = this
				// drop in a loading icon (to the left of the save-edit-trash column)
				var $loading = Icons.$loading.clone()
					.css({'left':'-60px'})
					.addClass('ui-state-default ui-corner-all ui-icon-parent')
					.appendTo($el)
				
				if(instance.id == 0){ // thios is our indicator that we're adding a new item
					// send the data to the server for update
					$.post('<?php echo site_url() ?>blog/create_post/', instance.data, function(data){
						if(data.success){
							// swap back to "view" mode
							instance.id = data.id
							$el.attr({'id':'item-' + instance.id,'data-id':instance.id})
							instance.swapToView()
						} else {
							instance.notifyError(data.error)
							// notify user that there was an error
						}
						// fade and remove the loading icon
						$loading.fadeOut('slow',function(){$loading.remove()})
					}, 'json')
				} else {
					// send the data to the server for update
					$.post('<?php echo site_url() ?>blog/update_post/' + instance.id, instance.data, function(data){
						if(data.success){
							// swap back to "view" mode
							instance.swapToView()
						} else {
							instance.notifyError(data.error)
							// notify user that there was an error
						}
						// fade and remove the loading icon
						$loading.fadeOut('slow',function(){$loading.remove()})
					}, 'json')
				}
			}, // end saveEdit()
			
			deleteItem: function() {
				var instance = this
				var confirmation = confirm('Are you sure you want to delete this post?')
				if(!confirmation) return
				
				var $loading = Icons.$loading.clone()
					.css({'left':'-60px'})
					.addClass('ui-state-default ui-corner-all ui-icon-parent')
					.appendTo($el)
				
				if(instance.id != 0){
					$.post('<?php echo site_url() ?>blog/delete_post/' + instance.id, function(data){
						if(data.success){
							$el.fadeOut('slow',function(){$el.remove()})
						} else {
							instance.notifyError(data.error)
							// notify user that there was an error
						}
					}, 'json')
				} else {
					$el.fadeOut('slow',function(){$el.remove()})
				}
			}, // end deleteItem()
			
			swapToView:function(){
				var instance = this // actions variable
				// make our form disappear (and remove it!
				if(instance.id == 0){
					$el.fadeOut('slow', function(){$el.remove()})
				} else {
					$el.find('form').css({'position':'absolute'}).hide().remove()
					
					// retrieve the item fresh from the server
					$.getJSON('<?php echo site_url() ?>blog/get_post/' + instance.id, function(data){
						// remove the edit-mode class
						$el.removeClass('edit-mode')
						// change the cancel icon to a pencil icon (edit)
						$el.find('.ui-icon-cancel').removeClass('ui-icon-cancel').addClass('ui-icon-pencil')
						// populate the entry with the fresh data
						$.each(instance.frontEndElements, function(z,el_data){el_data = el_data[0]
							var $child_el = $el.find('.' + el_data.field_name).text(data[el_data.field_name])
							$child_el.show()
						})					
					})
				}
			}, // end swapToView()
			
			getEditForm: function(){
				var instance = this // actions variable
				var $form = $('<form method="post" action=""/>')
								
				$.each(instance.backEndElements, function(z, el_data){ el_data = el_data[0]
					var $field
					if(el_data.field_type == 'text'){
						$field = Input.$text.clone()
					} else if(el_data.field_type == 'textbox'){
						$field = Input.$textbox.clone()
					}
					$field.val(instance.data[el_data.field_name]).attr({
						'name':el_data.field_name,
						'placeholder':el_data.pretty_name})
						.appendTo($form)
					
					if((el_data.field_name).match(/datetime/)){
						$field.datetimepicker({dateFormat:'yy-mm-dd'})
					}
				})
				return $form
			} // end getEditForm()
		}// end actions

		// specify run=true when we clone a new one, as run() inits a whole buncha stuff
		if(options.run){
			formActions.run()
		}
	
	}})(jQuery)
	
	$('html.admin div.hentry').each(function(z, el){
		$(el).attachAdmin()
	})
})

</script>