<?php
require_once('../Classes/PageAdmin.php');
require_once('../BizLayer/SupplierBiz.php');
require_once('../Classes/DataGrid.php');
$CTbiz = new SupplierBiz();

$pageContent = "<h1>Manage Suppliers</h1>";

//handle save and delete actions if requested
$action = (array_key_exists('action', $_REQUEST)) ? $_REQUEST['action'] : '';
if ($action != '') 
{
	if ($action == 'save')
	{
		
		$isNewRec = (array_key_exists('S_ID', $_REQUEST) && $_REQUEST['S_ID'] != '') ? false : true;
		if ($isNewRec)
		{
			if ($CTbiz->createSupplier($_POST) !== false ) 
			{
				$pageContent .= '<p class="success">The Supplier record was successfully created.</p>';
			} else {
				$pageContent .= '<p class="error">Failed to create the Supplier record!</p>';
			}
		} 
		else 
		{
			if ($CTbiz->updateSupplier($_POST) !== false ) 
			{
				$pageContent .= '<p class="success">The Supplier record was successfully update.</p>';
				//send email
			} else {
				$pageContent .= '<p class="error">Failed to update the Supplier record!</p>';
			}
		}
	} 
	else if ($action == 'delete')
	{
		if ($CTbiz->deleteSupplier($_REQUEST['id']) !== false ) 
		{
			$pageContent .= '<p class="success">The Supplier record was successfully deleted.</p>';
		} else {
			$pageContent .= '<p class="error">Failed to delete the Supplier record!</p>';
		}
	}
	
}

$CTdata = $CTbiz->getAllSuppliers();

//fields to display in datagrid
$cols = array(
	'S_ID' => 'ID',
	'S_Name' => 'Supplier Name',
	'S_PhoneWork' => 'Phone (work)',
	'S_PhoneMobile' => 'Mobile',
	'S_Email' => 'Email',
	'S_Street' => 'Street',
	'S_Suburb' => 'Suburub',
	'S_City' => 'City'
	);

$dg = new DataGrid($cols, 'S_ID', $CTdata, 'SupplierForm.php?id=', $_SERVER['PHP_SELF'] . '?action=delete&id=', array());

$pageContent .= '<a style="margin:10px; display:block;" href="SupplierForm.php">Add a new Supplier</a>';
$pageContent .= $dg->render();


$thePage = new pageAdmin('Manage Supplier | Quality Cars', 'Manage Supplier', $pageContent);
echo $thePage->render();


?>