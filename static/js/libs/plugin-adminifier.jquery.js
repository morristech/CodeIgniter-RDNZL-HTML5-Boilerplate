(function($){
	$.widget('adminifier',{
		options:{
			'text':'Blah Blah'
		},
		el: this,
		
		_create:function(){},
		
		_init:function(){
			var self = this;
			
			el.text(getOption('text'));
		},
		
		_destroy:function(){},
		
	});
}(jQuery));