(function($){
	
	$('#login_blocker_message').hide();
	
	$("body").data('item', '#login_blocker').on('keydown', function(evt){
		
		var keyCode = ('which' in evt) ? evt.which : evt.keyCode;
		var $this = $(this),
		filter;
		
		filter = (evt.altKey || evt.ctrlKey || evt.shiftKey || keyCode == 32);
		
		if(filter){
			$('#login_blocker_message').show();
			evt.preventDefault();
		}
		else{
			$('#login_blocker_message').hide();
		}
		
	});
	
})(jQuery)
