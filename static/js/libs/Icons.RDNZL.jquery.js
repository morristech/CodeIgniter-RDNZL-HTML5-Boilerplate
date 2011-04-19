var Icons = {
	// our sitewide icons that we'll clone() from as needed
	// they need to be in this parent-child format. see the 
	// jQuery UI Icon Framework page for more info. FYI: there's some
	// styles related to these guys in /static/css/jquery-ui-themes/site_extras.css
	$edit: 		$('<a class="edit-trigger">		<span class="ui-icon-pencil"/></a>'),
	$add: 		$('<a class="add-trigger">		<span class="ui-icon-plus"/></a>'),
	$save: 		$('<a class="save-trigger">		<span class="ui-icon-disk"/></a>'),
	$delete: 	$('<a class="delete-trigger">	<span class="ui-icon-trash"/></a>'),
	$loading: 	$('<div>						<img src="/static/images/icons/loading.gif"/></div>'),

	// there's an init function, there's probably a smoother way to handle these needs, but here's the
	// rundown on what this does. in a nutshell: iterate over our icon elements, and set up their classes.
	// for anchor elements, give them an href of javascript:void(0). at the end of the day, our code
	// above is a bit prettier, and this part below adds reliability to making sure we "class" our icons rightly.
	init: function(){
		var instance = this;
		
		// add our icons from above into this array
		var $icons = new Array(
			instance.$edit, 
			instance.$add, 
			instance.$save, 
			instance.$delete, 
			instance.$loading
		)
		
		// iteration block on $icons
		$.each($icons, function(z,$el){
			$el
				// add these classes to our parent element
				.addClass('ui-state-default ui-corner-all ui-icon-parent')
				// we're definitely going to be favoring absolute positioning in our layouts,
				// so set up some basic css for that: position, top, and left
				.css({'position':'absolute', 'top':'0px', 'left':'0px'})
				// find our inner element (should only be one), and add class of ui-icon.  
				.children().addClass('ui-icon')
			
			// find out if this is an anchor element. if so, set up the href
			if($el.is('a')) $el.attr('href','javascript:void(0)');
		});
		// end iteration block
	}
}

