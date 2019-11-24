//Javascript for the page CarTypes.php

$(document).ready(function() { //when the document is ready
	
	//do field validations on submit of the form
	$('#CarType').submit(function() {
		
		
		if ( $('#CT_Make').val() == '' ) {
			return addErrorMsg( $('#CT_Make'), 'You must enter a the Car Type\'s Make!');	
		}
		
		if ( $('#CT_Model').val() == '' ) {
			return addErrorMsg( $('#CT_Model'), 'You must enter the Car Type\'s Model!');	
		}

		if ( $('#CT_Price').val() == '' || isNaN($('#CT_Price').val()) ) {
			return addErrorMsg( $('#CT_Price'), 'You must enter your Car Type\'s Price and it should be a number!');	
		}
		
		
	});
	
	
});



