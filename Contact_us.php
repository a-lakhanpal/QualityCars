<?php

/** Contact us form and page **/
require_once('Classes/PageCustomer.php');
require_once('Classes/Form.php');

$cont = '';

$reqAction = (array_key_exists('action', $_REQUEST)) ? $_REQUEST['action'] : '';

if ($reqAction == 'send') //if it's requested to send contact info
{
	$msg = "Name: " . $_POST['C_Name'] . "\n";
	$msg .= "Phone: " . $_POST['C_Phone'] . "\n";
	$msg .= "Website: " . $_POST['C_Website'] . "\n";
	$msg .= "\n" . $_POST['C_Message'];
	
	mail("basir.noutash@gmail.com", 'Quality Cars Contact Form', $msg, "From: ".$_POST['C_Email']);
	
	$cont .= '<p class="success">Thank you for contacting us. We will get back to you as soon as we can!</p>';
	
} 

buildForm();

//build the contact form
function buildForm()
{
	global $cont;
	//form title
	$formTitle='Contact us';
	
	//form instructions
	$instruct = '<p><strong>Quality Cars Limited</strong></p>';
	$instruct .= '<p>123 Pleasant Street</p>';
	$instruct .= '<p>Auckland 5555</p>';
	$instruct .= '<p>New Zealand</p>';
	$instruct .= '<p>Email: info@QualityCars.com</p>';
	$instruct .= '<p>Phone: +64 (9) 242345235 </p>';
	
	$formAction = $_SERVER['PHP_SELF'] . '?action=send';
	
	$fields = array( 'C_Name' => array('text' => 'Name'));
	$fields['C_Email']['text'] = 'Email';
	$fields['C_Phone']['text'] = 'Phone';
	$fields['C_Website']['text'] = 'Website';
	$fields['C_Message']['textarea'] = 'Message';
	
	
	$userForm = new Form('contact-64.png', $formTitle, $instruct, $fields, array(), 'Contact', $formAction, 'Send', '');
	$cont .= $userForm->render();
}

//create the page object
$thePage = new PageCustomer('Contact | Quality Cars', 'Contact us', $cont);
array_push($thePage->cssSources, 'forms.css');
array_push($thePage->jsSources, 'form.js', 'contact.js');
echo $thePage->render();

?>
