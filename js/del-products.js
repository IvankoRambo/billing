(function($){
	
	$('#delete-form').on('submit', function(evt){
		
		evt.preventDefault();
		
		$('.load_deldiv').load('delprod #deldiv', function(response, status, xhr){
			
			$('#no').on('click', function(){
				$('#deldiv').remove();
			});
			
		});
		
	});
	
})(jQuery)

