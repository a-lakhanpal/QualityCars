//Javascript for the page SupplierForm.php

$(document).ready(function() { //when the document is ready
	
	//do field validations on submit of the form
	$('#Supplier').submit(function() {
		
		if ( !isValidEmail( $('#S_Email').val() ) ) {
			return addErrorMsg( $('#S_Email'), 'Please enter a valid email address.');	
		}
		
		if ( $('#S_Name').val() == '' ) {
			return addErrorMsg( $('#S_Name'), 'You must enter the supplier\s Name!');	
		}
		
	});
	
	
});



