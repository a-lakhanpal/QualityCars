/** javascript functions that may be used on all forms **/


$(document).ready(function() {
	
	//clear errors when any field is changed
	$('input').change(function() {
		$(this).removeClass('invalid');
		$(this).next('br').remove();
		$(this).next('span').remove();
	});
	
});



/** function that adds error messages when a field has incorrect value
 * @param elem: the element that the error should be added to
 * @param msg: the error message to be added
**/
function addErrorMsg(elem, msg) {
	$(elem).trigger('change'); //clear out previous errors
	$(elem).addClass('invalid');
	$(elem).after('<br /><span class="error small">' + msg + '</span>');
	$(elem).focus();
	return false;
}


/**
 * function that tests if an email address is valid using regex
 **/
 1
function isValidEmail(emailAddress) {

	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);

	return pattern.test(emailAddress);

}
