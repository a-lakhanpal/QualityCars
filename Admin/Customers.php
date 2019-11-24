<?php
require_once('../Classes/PageAdmin.php');
require_once('../BizLayer/UserBiz.php');
require_once('../Classes/DataGrid.php');
$UserBiz = new UserBiz();

$pageContent = "<h1>Manage Customers</h1>";

//handle toggle status if requested if requested
$action = (array_key_exists('action', $_REQUEST)) ? $_REQUEST['action'] : '';
if ($action == 'status') 
{
	$user = $UserBiz->getUserByID($_REQUEST['id']);
	
	if ($user['U_Status'] == 'Disabled')
	{
		$post = array('U_Status' => 'Enabled', 'U_ID' => $_REQUEST['id']);
	} 
	else if ($user['U_Status'] == 'Enabled')
	{
		$post = array('U_Status' => 'Disabled', 'U_ID' => $_REQUEST['id']);
	} 
	else 
	{
		$post = array('U_Status' => 'Disabled', 'U_ID' => $_REQUEST['id']);
	}
	
	if ($UserBiz->updateUser($post) !== false ) 
	{
		$pageContent .= '<p class="success">The User Status was successfully updated.</p>';
	} else {
		$pageContent .= '<p class="error">Failed to update the Users Status!</p>';
	}
}

$users = $UserBiz->getAllUsers();

//fields to display in datagrid
$cols = array(
	'U_ID' => 'ID',
	'U_FirstName' => 'First Name',
	'U_LastName' => 'Last Name',
	'U_PhoneHome' => 'Phone (home)',
	'U_PhoneWork' => 'Phone (work)',
	'U_Email' => 'Email',
	'U_Suburb' => 'Suburub',
	'U_City' => 'City', 
	'U_Status' => 'Status'
	);
	
//custom button to disable/enable  status of the user
$custCol = array( "Enable/Disable" =>
	$_SERVER['PHP_SELF'] . "?action=status&id="
	);

$dg = new DataGrid($cols, 'U_ID', $users, '', '', $custCol);

$pageContent .= $dg->render();


$thePage = new pageAdmin('Manage Customers | Quality Cars', 'Manage Customers', $pageContent);
echo $thePage->render();


?>