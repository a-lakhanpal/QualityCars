//Javascript for the page register.php

$(document).ready(function() { //when the document is ready
	
	//do field validations on submit of the form
	$('#Contact').submit(function() {
		
		if ( !isValidEmail( $('#C_Email').val() ) ) {
			return addErrorMsg( $('#C_Email'), 'Please enter a valid email address.');	
		}
		
		if ( $('#C_Name').val() == '' ) {
			return addErrorMsg( $('#C_Name'), 'You must enter your name!');	
		}

		if ( $('#C_Message').val() == '' ) {
			return addErrorMsg( $('#C_Message'), 'Please type in what you want to tell us!');	
		}
		
	});
	
	
});



