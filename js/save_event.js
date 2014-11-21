// Javascript Document

/*
	This is used to tap into the Ajax Event Calendar Event Save functions. An AJAX call is made to connect with and send information to the CCB API to create the event in their calendar 
*/ 

jQuery(function ($) {
	$(document).ajaxSend(function( event, request, settings ) {
  		if ($("#add_event").length){
			window.formfields = $('#event-form').serialize();
					
		}
  	});
	$(document).ajaxStop(function( event, request, settings ) {
		if(window.formfields) {
			if($("#add_event").length == 0){
				var formData = window.formfields;
				delete window.formfields;
			
				$.post( ajaxurl,{ action: "add_ccb_event", event: formData },function(data){});
			}
		}
  	});
	
});
