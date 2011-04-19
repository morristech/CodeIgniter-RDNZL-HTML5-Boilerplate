var Icons = {
	$edit: $('<a href="#" class="ui-state-default ui-corner-all ui-icon-parent edit-trigger"><span class="ui-icon ui-icon-pencil"/></a>'),
	$save: $('<a href="#" class="ui-state-default ui-corner-all ui-icon-parent save-trigger"><span class="ui-icon ui-icon-disk"/></a>'),
	init: function(){
		var instance = this;
		var icons = new Array(instance.$edit, instance.$save)
		$.each( icons, function(z,el){
			$(el)
				.hover(
					function(){ 
						$(el).addClass("ui-state-hover") 
						var foo=0;
					},
					function(){ 
						$(el).removeClass("ui-state-hover") 
						var foo=0;
					}
				)
				.css({
					'position':'absolute',
					'top':'0px',
					'left':'0px'
				})
		});
	}
}
