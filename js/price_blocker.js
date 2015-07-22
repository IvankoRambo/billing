(function($){
	
	$('#block_message').hide();
	
	$('#price_input').on('keydown', function(evt){
		
		var keyCode = ('which' in evt) ? evt.which : evt.keyCode;
		var $this = $(this),
		filter;
		
		if($this.val() == false){
			filter = (keyCode >= 49 && keyCode <= 57) || (keyCode >= 96 && keyCode <= 105) || (keyCode == 8);
		}
		else{
			filter = (keyCode >= 48 && keyCode <= 57) || (keyCode >= 96 && keyCode <= 105) || (keyCode == 8) || (keyCode == 190);
		}
		
		if(!filter || ( keyCode == 190 &&  ($this.val().indexOf('.') !== -1)) ){
			$('#block_message').show();
			evt.preventDefault();
		}
		else{
			$('#block_message').hide();
		}
		
	});
	
})(jQuery)
