<?php

/** page that display either blank or filled car type form **/

require_once('../Classes/PageAdmin.php');
require_once('../BizLayer/CarTypeBiz.php');
require_once('../Classes/Form.php');

$cont = '';
$guide = '<p>Please enter the Car Type details and click Submit</p>';
$formAction = 'CarTypes.php?action=save';
$data = array();
	
$fields = array( 'CT_Make' => array('text' => 'Make'));
$fields['CT_Model']['text'] = 'Model';
$fields['CT_Year']['text'] = 'Year';
$fields['CT_Color']['text'] = 'Color';
$fields['CT_Price']['text'] = 'Price';
$fields['CT_Desc']['text'] = 'Description';
$fields['CT_Photo']['file'] = 'Photo';
$fields['CT_SupplierID']['text'] = 'Supplier ID';
$fields['CT_ID']['hidden'] = '';

if (array_key_exists('id', $_REQUEST) && $_REQUEST['id'] != '') 
{
	$bizLayer = new CarTypeBiz();
	
	$data = $bizLayer->getCarTypeByID($_REQUEST['id']);
	$formAction .= '&id=' . $_REQUEST['id'];
	$guide .= '<p>The Car Type ID is: ' . $_REQUEST['id'] ;
	
}

$form = new Form('car.png', 'Car Type Form', $guide, $fields, $data, 'CarType', $formAction, 'Submit', '');
$cont .= $form->render();

$thePage = new PageAdmin('Manage Car Types | Quality Cars', '', $cont);
array_push($thePage->cssSources, 'forms.css');
array_push($thePage->jsSources, 'form.js');
array_push($thePage->jsSources, 'cartypes.js');
echo $thePage->render();

?>