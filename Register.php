<?php

/** Page displaying user profile or new customer registration form **/
require_once('Classes/PageCustomer.php');
require_once('Classes/Form.php');
require_once('BizLayer/UserBiz.php');

$bizLayer = new UserBiz();
$cont = '';

$reqAction = (array_key_exists('action', $_REQUEST)) ? $_REQUEST['action'] : '';

if ($reqAction == 'save') //if it's requested to save the profile
{
	//add the status field as it's not on the form
	$_POST['U_Status'] = "Enabled";
	$_POST['U_Role'] = "Customer";
	
	$newUser = (array_key_exists('U_ID', $_REQUEST) && $_REQUEST['U_ID'] != '') ? false : true;
	if ($newUser) 
	{ //create a new user record
		if ($bizLayer->createUser($_POST) !== false ) 
		{
			$cont = '<p class="success">Your profile was successfully submitted. You will receive an email with confirmation of your account details. Please click the Log in menu to log in with your new account details.</p>';
			
			//send email
			date_default_timezone_set('Pacific/Auckland');
			mail("basir@noutash.com", "Quality Cars: A customer registered!", "Dear " . $_POST['U_FirstName'] . "\n\n You registered on Quality Cars. Here are your account details:\n\n User Name: " . $_POST['U_Email'] . "\n" . "Passwod: " . $_POST['U_Password'], "From: info@QualityCars.com");
		} else {
			$cont = '<p class="error">Failed to create your profile in the database!</p>';
		}
		
	} 
	else //not new user - update user record
	{
		if ($bizLayer->updateUser($_POST) !== false ) 
		{
			$cont = '<p class="success">Your profile was successfully updated.</p>';
			//send email
		} else {
			$cont = '<p class="error">Failed to update your profile in the database!</p>';
		}
	}
	
} 
else 
{
	buildForm();
}


//build the user registration form
function buildForm()
{
	global $cont;
	//form title
	$formTitle='New Customer Registration';
	
	//form instructions
	$instruct='<p>This form is used to register your profile so you can order Cars as a customer.</p>';
	$instruct .= '<p>Please ensure you note the email address and password you provide on this form as these information will be used to authenticate you to our ordering section.</p>';
	$instruct .= '<p>When you register for the first time, an email will be sent to you confirming your registration. Please ensure you provide a correct email address.</p>';
	
	$formAction = $_SERVER['PHP_SELF'] . '?action=save';
	
	$fields = array( 'U_Email' => array('text' => 'Email <small>will also be used as your username</small>'));
	$fields['U_Password']['password'] = 'Password';
	$fields['U_FirstName']['text'] = 'First Name';
	$fields['U_LastName']['text'] = 'Last Name';
	$fields['U_PhoneHome']['text'] = 'Phone (home)';
	$fields['U_PhoneWork']['text'] = 'Phone (work)';
	$fields['U_PhoneMobile']['text'] = 'Phone (mobile)';
	$fields['U_Fax']['text'] = 'Fax';
	$fields['U_Street']['text'] = 'Street Address';
	$fields['U_Suburb']['text'] = 'Suburb';
	$fields['U_City']['text'] = 'City';
	$fields['U_ID']['hidden'] = '';
	
	$data = array();
	if (array_key_exists('UserType', $_SESSION) && $_SESSION['UserType'] == 'Customer') 
	{ //if user is logged in then we want to load user's data into the form
		$uid = $_SESSION['User']['U_ID'];
		$bizLayer = new UserBiz();
		$data = $bizLayer->getUserByID($uid);
	}
	
	$userForm = new Form('people.png', $formTitle, $instruct, $fields, $data, 'Customer', $formAction, 'Submit', '');
	$cont = $userForm->render();
}

//create the page object
$thePage = new PageCustomer('Customer Profile | Quality Cars', 'My Profile', $cont);
array_push($thePage->cssSources, 'forms.css');
array_push($thePage->jsSources, 'form.js', 'register.js');
echo $thePage->render();

?>
