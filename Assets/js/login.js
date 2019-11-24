/** javascript for login form **/

$(document).ready(function() {
	
//do field validations on submit of the form
	$('#Login').submit(function() {
		
		if ( $('#U_Email').val() == '') {
			return addErrorMsg( $('#U_Email'), 'Please enter a valid email address.');	
		}
		
		if ( $('#U_Password').val() == '' ) {
			return addErrorMsg( $('#U_Password'), 'You must enter a password!');	
		}
	
		
	});
	
});