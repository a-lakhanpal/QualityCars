//Javascript for the page register.php

$(document).ready(function() { //when the document is ready
	
	//do field validations on submit of the form
	$('#Customer').submit(function() {
		
		if ( !isValidEmail( $('#U_Email').val() ) ) {
			return addErrorMsg( $('#U_Email'), 'Please enter a valid email address.');	
		}
		
		if ( $('#U_Password').val() == '' ) {
			return addErrorMsg( $('#U_Password'), 'You must enter a password!');	
		}
		
		if ( $('#U_FirstName').val() == '' ) {
			return addErrorMsg( $('#U_FirstName'), 'You must enter your first name!');	
		}

		if ( $('#U_LastName').val() == '' ) {
			return addErrorMsg( $('#U_LastName'), 'You must enter your last name!');	
		}
		
	});
	
	
});



