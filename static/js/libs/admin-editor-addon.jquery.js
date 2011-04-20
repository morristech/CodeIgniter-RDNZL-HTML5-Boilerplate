
(function($){ 

$.fn.attachAdmin = function(options) {
	// Set up our options var
	if(!options){
		options = {}
	} else{
		// set up required options.
		options.run = (!options.run) ? false : options.run;
		options.backEndElements = (!options.backEndElements) ? Array() : options.backEndElements;
		options.frontEndElements = (!options.frontEndElements) ? Array() : options.frontEndElements;
		options.handlerURLs = (!options.handlerURLs) ? Array() : options.handlerURLs;
	}
	// grab our container el. we reference this all over the place, might be a better OOP
	// way to get the job done... like assigning $el to a property of formActions class?
	var $el = $(this).css({'position':'relative'})
	
	// and here's our "class"
	var formActions = {
		// properties
		id: $el.data('id'),
		data: {},
		options: {},
		// here are our icons/triggere
		$add_trigger: Icons.$add.clone()		.css({'left':'-30px','top':'30px'}),
		$edit_trigger: Icons.$edit.clone()		.css({'left':'-30px'}),
		$save_trigger: Icons.$save.clone()		.css({'left':'-60px','top':'00px'}),
		$delete_trigger: Icons.$delete.clone()	.css({'left':'-60px','top':'30px'}),
		
		// REQUIRED PARAMS
		// form elements & handler URLs
		frontEndElements: Array(),
		backEndElements: Array(),
		handlerURLs:{
			create:'',
			read:'',
			update:'',
			del:''
		},
		
		// methods
		// init function: basically this function attaches the action buttons
		// to the $el. not much more than that
		_init:function(options){
			var instance = this;
			instance.options = options;
			
			instance.frontEndElements = options.frontEndElements;
			instance.backEndElements = options.backEndElements;
			instance.handlerURLs = options.handlerURLs;
			
			var formIcons = new Array(
				instance.$edit_trigger.click(function(){ instance.run() }),
				instance.$save_trigger.click(function(){ instance.triggerSaveItem() }),
				instance.$delete_trigger.click(function(){ instance.deleteItem() }), 
				instance.$add_trigger.click(function(){ instance.insertNew() })
			)
			
			$.each(formIcons, function(z, $trigger_el){
				$trigger_el
					.hover(
						function(){$(this).addClass("ui-state-hover")},
						function(){$(this).removeClass("ui-state-hover")}
					)
					.appendTo($el)
			})
		},
		
		// this is our "do-er" function. the name isn't quite right though, semantically that is
		// since this is really more of a toggle function between edit & view mode
		run:function(){
			var instance = this // actions variable
			if(!instance.isEditMode()){
				instance.swapToEdit()
			} else {
				instance.swapToView()
			}
		},
		
		// returns true or falso depending on if $el has a class of "edit-mode"
		isEditMode: function(){ return $el.hasClass('edit-mode') ? true : false},
		
		// generic error notification function, pops up a UI dialog
		notifyError:function(msg){
			var instance = this
			var dialogOptions = { modal: true, resizable: false, draggable: false, dialogClass: 'widget-error-msg' }				
			var $div = $('<div title="Error"/>')
				.appendTo($el)
				.html(msg)
				.dialog(dialogOptions)				
		},
		
		// this function is the first part of the Create New functionality. basically we clone the
		// existing item, remove the icons (determined by .ui-icon-parent class), and remove the form
		// if it exists, then we execute the run function to get us into edit mode
		insertNew:function(){
			var instance = this
			var $new_el = $el.clone()
			$new_el				
				.attr({'id':'item-0','data-id':'0'}) // set the id's to 0 in both data, as well as the element ID
				.find('.ui-icon-parent').remove() // remove any existing icons
				.find('form').remove() // remove any existing form el(s)
			// now attach/execute attachAdmin and run it (swaps us to edit view)
			var options = instance.options;
			options.run = true;
			$new_el.attachAdmin(options)
			// and append our new el to the DOM, in front of this current el.
			$new_el.insertBefore($el)
		},
		
		// not sure that we need this function.
		setupDataProperty:function(){
			$.each(instance.backEndElements, function(z, el_data){ // el_data = el_data[0]
				instance.data[el_data.field_name] = ''
			})
		},
		
		// this function performs the swap to Edit mode.
		swapToEdit: function(){
			var instance = this // actions variable
			var setupEl = function(){
				$el
					.addClass('edit-mode') // set the class to edit-mode, this ties into a couple CSS hooks
					// find our pencil icon, change it to a "cancel" iucon
					.find('.ui-icon-pencil').removeClass('ui-icon-pencil').addClass('ui-icon-cancel').end()
					// grab all child elements that are NOT icons, and hide them.
					.children(':not(.ui-icon-parent)').hide()
			}
			// get our form & set it up 
			var setupForm = function(){
				var $form = instance.getEditForm()
					.submit(function(e){ // submit handler for "Save Item" functionality.
						e.preventDefault()
						instance.assembleUserData() // collect data from inputs
						instance.saveItem() // execute the save
					})
					// add the new form element to $el
					.appendTo($el)
			}
			// request the data from the server, but only if we're NOT creating a new
			// item (which is the case if instance.id = 0)
			if(instance.id != 0){
				$.getJSON(instance.handlerURLs.read + instance.id, function(data){
					// add class='edit-mode' to our container element (css hook)
					instance.data = data
					setupEl()
					setupForm()						
				})
			} else { // we're making a new one, so just stup the el and setup the form.
				setupEl()
				setupForm()
			}
		}, // end swapToEdit()
		
		// this function collects the data from the inputs and overwrites it to instance.data
		assembleUserData: function(){
			var instance = this // actions variable
			instance.data = {ajax:true} // this signals our server handler that we want JSON back
			
			// iterate over instance.backEndElements, and grab our data. we use field_type and field_name
			// to generate our selector, something like $(input[name=FIELDNAME]).
			$.each(instance.backEndElements, function(z,el_data){
				var tag
				if(el_data.field_type == 'text'){
					tag = 'input'
				} else {
					tag = 'textarea'
				} // we need to add more else stements to handle radio buttons, check boxes, and selects
				
				// now that we have decided what tag to look for, look it up and add the .val() to instance.data
				instance.data[el_data.field_name] = $(tag + '[name=' + el_data.field_name + ']', $el).val()
			})
		},
		
		// this basically triggers the submit() function in the form. nothing more.
		triggerSaveItem: function() {		
			var instance = this // actions variable
			var $form = $el.find('form')
			$form.submit()		
		},
		
		// this is the real save function
		saveItem:function(){
				
			var instance = this
			// drop in a loading icon (to the left of the save-edit-trash column)
			var $loading = Icons.$loading.clone()
				.css({'left':'-60px'})
				.addClass('ui-state-default ui-corner-all ui-icon-parent')
				.appendTo($el)
			
			if(instance.id == 0){ // this is our indicator that we're adding a new item
				// send the data to the server for the new item
				$.post(instance.handlerURLs.create, instance.data, function(data){
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
				$.post(instance.handlerURLs.update + instance.id, instance.data, function(data){
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
				$.post(instance.handlerURLs.del + instance.id, function(data){
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
				$.getJSON(instance.handlerURLs.read + instance.id, function(data){
					// remove the edit-mode class
					$el.removeClass('edit-mode')
					// change the cancel icon to a pencil icon (edit)
					$el.find('.ui-icon-cancel').removeClass('ui-icon-cancel').addClass('ui-icon-pencil')
					// populate the entry with the fresh data
					$.each(instance.frontEndElements, function(z,el_data){// el_data = el_data[0]
						var foo = 0;
						var $child_el = $el.find('.' + el_data.field_name).text(data[el_data.field_name])
						$child_el.show()
					})					
				})
			}
		}, // end swapToView()
		
		getEditForm: function(){
			var instance = this // actions variable
			var $form = $('<form method="post" action=""/>')
			
			// iterate over backEndElements: create a field, populate it with data, and 
			// add it to the form
			$.each(instance.backEndElements, function(z, el_data){
				var $field
				if(el_data.field_type == 'text' || el_data.field_type == 'datetime' || el_data.field_type == 'int'){
					// need to flesh this out to properly handle enum->select menu
					$field = Input.$text.clone()
				} else if(el_data.field_type == 'longtext'){
					$field = Input.$textbox.clone()
				} else if(el_data.field_type == 'enum'){
					$field = Input.$select.clone();
					if(!el_data.field_options){
						// throw error, we need to have options for enum-type field
						instance.notifyError('There are no options for select menu: ' + el_data.nice_name);
					} else {
						$.each(el_data.field_options, function(z, enum_opt){
							$option = $('<option/>').val(enum_opt).text(enum_opt)
								.appendTo($field);
						});
					}
				}
				var $label = $('<label>');
				$label.text(el_data.nice_name);
				
				$field.val(instance.data[el_data.field_name]).attr({
					'name':el_data.field_name,
					'placeholder':el_data.nice_name})
					.appendTo($label)
					
				$label.appendTo($form);
					
				
				if((el_data.field_name).match(/datetime/)){
					$field.datetimepicker({dateFormat:'yy-mm-dd'})
				}
			})
			return $form;
		} // end getEditForm()
	}// end actions

	// This is it, people. Now launche this bad boy.
	formActions._init(options);
	if(options.run){ formActions.run(options) }
}
})(jQuery)
