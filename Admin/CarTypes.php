<?php
require_once('../Classes/PageAdmin.php');
require_once('../BizLayer/CarTypeBiz.php');
require_once('../Classes/DataGrid.php');
$CTbiz = new CarTypeBiz();

$pageContent = "<h1>Manage Car Types</h1>";

//handle save and delete actions if requested
$action = (array_key_exists('action', $_REQUEST)) ? $_REQUEST['action'] : '';
if ($action != '') 
{
	if ($action == 'save')
	{		
		
		unset($_POST['CT_Photo']);
	
		//save the uploaded image
		
		if ((($_FILES["CT_Photo"]["type"] == "image/gif")
		|| ($_FILES["CT_Photo"]["type"] == "image/jpeg")
		|| ($_FILES["CT_Photo"]["type"] == "image/png")
		|| ($_FILES["CT_Photo"]["type"] == "image/bmp")
		|| ($_FILES["CT_Photo"]["type"] == "image/bitmap")
		|| ($_FILES["CT_Photo"]["type"] == "image/tiff")
		|| ($_FILES["CT_Photo"]["type"] == "image/pjpeg")))
		  {
		 		if ($_FILES["CT_Photo"]["error"] > 0)
				{
				$pageContent .=  "<p class='error'>Return Code: " . $_FILES["file"]["error"] . "</p>";
				}
			  	else
				{
				  move_uploaded_file($_FILES["CT_Photo"]["tmp_name"],
				  APP_ROOT."DataLayer\\Car_Images\\" . $_FILES["CT_Photo"]["name"]);
				  $_POST['CT_Photo'] = $_FILES["CT_Photo"]["name"];
				}
		  }
		else
		  {
		  		$pageContent .= "<p class='error'>You tried to upload an invalid file type. We only accept gif, png, jpg and bmp.</p>";
		  }

		
		$isNewRec = (array_key_exists('CT_ID', $_REQUEST) && $_REQUEST['CT_ID'] != '') ? false : true;
		if ($isNewRec)
		{
			if ($CTbiz->createCarType($_POST) !== false ) 
			{
				$pageContent .= '<p class="success">The Car Type record was successfully created.</p>';
			} else {
				$pageContent .= '<p class="error">Failed to create the Car Type record!</p>';
			}
		} 
		else 
		{
			if ($CTbiz->updateCarType($_POST) !== false ) 
			{
				$pageContent .= '<p class="success">The Car Type record was successfully update.</p>';
			} else {
				$pageContent .= '<p class="error">Failed to update the Car Type record!</p>';
			}
		}
	} 
	else if ($action == 'delete')
	{
		if ($CTbiz->deleteCarType($_REQUEST['id']) !== false ) 
		{
			$pageContent .= '<p class="success">The Car Type was successfully deleted.</p>';
		} else {
			$pageContent .= '<p class="error">Failed to delete the Car Type!</p>';
		}
	}
	
}

$CTdata = $CTbiz->getAllCarTypes();

//convert photo values to image tags
foreach ($CTdata as &$row)
{
	$row['CT_Photo'] = '<img width="100" src="'.APP_URI.'DataLayer/Car_Images/' . $row['CT_Photo'] . '" />';
}

//fields to display in datagrid
$cols = array(
	'CT_Photo' => '',
	'CT_ID' => 'ID',
	'CT_Make' => 'Make',
	'CT_Model' => 'Model',
	'CT_Year' => 'Year',
	'CT_Color' => 'Color',
	'CT_Price' => 'Price',
	'CT_Desc' => 'Description'
	);

$dg = new DataGrid($cols, 'CT_ID', $CTdata, 'CarTypeForm.php?id=', $_SERVER['PHP_SELF'] . '?action=delete&id=', array());

$pageContent .= '<a style="margin:10px; display:block;" href="CarTypeForm.php">Add a new Car Type</a>';
$pageContent .= $dg->render();


$thePage = new pageAdmin('Manage Car Types | Quality Cars', 'Manage Car Types', $pageContent);
echo $thePage->render();


?>