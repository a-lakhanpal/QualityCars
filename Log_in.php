<?php

/** Log in page **/

require_once('Classes/PageCustomer.php');
require_once('Classes/Form.php');
require_once('BizLayer/UserBiz.php');

$customCode = '';
$cont = '';

$reqAction = (array_key_exists('action', $_REQUEST)) ? $_REQUEST['action'] : '';

if ($reqAction == 'login') { //log user in
	
	//if it's admin
	if ($_REQUEST['U_Email'] == 'admin' && $_REQUEST['U_Password'] == 'test') 
	{
		$_SESSION['UserType'] = 'Admin';
		renderSuccess();
			
	} else { //not admin
		
		$userBiz = new UserBiz();
		$userRec = $userBiz->validateUser($_REQUEST['U_Email'], $_REQUEST['U_Password']);
		
		if ($userRec == false) {
			$customCode = '<p class="error">You entered an invalid user name or password!"</p>';
			renderLoginForm();
		} //prevent disabled users
		else if ($userRec['U_Status'] == 'Disabled')
		{
			$customCode = '<p class="error">Sorry, your account is disabled by the administrator and you cannot login!"</p>';
			renderLoginForm();
		} 
		else 
		{
			//put session flags indicating user is logged in
			$_SESSION['UserType'] = 'Customer';
			$_SESSION['User'] = $userRec;
			renderSuccess();
		}	
	}
	
} else if ($reqAction == 'logout') //if logout is requested
{
	unset($_SESSION['UserType']);
	unset($_SESSION['User']);
	$customCode = '<p class="success">You are now logged out!"</p>';
	renderLoginForm();
	
} else { //no action requested
	renderLoginForm();
}

//render login was success full
function renderSuccess()
{
	global $cont;
	$cont = '<h1>You are now logged in!</h1><p class="success">Your login was successfull. Please use the navigation menus to browse our website.</p>';	
}

//funciton to render the login form
function renderLoginForm()
{
	global $customCode, $cont;
	
	//form title
	$formTitle='User Log in';
	
	//form instructions
	$instruct='<p>You need to log in if you would like to place orders or if you are an Administrator and would like to access the admin area of the website.</p>';
	$instruct .= '<p>Please enter the user name and password that you entered when you registered.</p>';
	$instruct .= '<p>If you don not have an account yet, please'. ' <a href="Register.php">register</a></p>';
	
	$formAction = $_SERVER['PHP_SELF'] . '?action=login';
	
	$fields = array( 'U_Email' => array('text' => 'Your email address'));
	$fields['U_Password']['password'] = 'Password';
	
	
	$userForm = new Form('people.png', $formTitle, $instruct, $fields, array(), 'Login', $formAction, 'Log in', $customCode);
	$cont = $userForm->render();	
}

//create the page object
$thePage = new PageCustomer('Log in | Quality Cars', 'Log in', $cont);
array_push($thePage->cssSources, 'forms.css');
array_push($thePage->jsSources, 'form.js', 'login.js');
echo $thePage->render();

?>
