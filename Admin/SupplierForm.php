<?php

/** page that display either blank or filled supplier form **/

require_once('../Classes/PageAdmin.php');
require_once('../BizLayer/SupplierBiz.php');
require_once('../Classes/Form.php');

$cont = '';
$guide = '<p>Please enter the Supplier details and click Submit</p>';
$formAction = 'Suppliers.php?action=save';
$data = array();
	
$fields = array( 'S_Name' => array('text' => 'Name'));
$fields['S_PhoneHome']['text'] = 'Phone (home)';
$fields['S_PhoneWork']['text'] = 'Phone (work)';
$fields['S_PhoneMobile']['text'] = 'Phone (mobile)';
$fields['S_Fax']['text'] = 'Fax';
$fields['S_Email']['text'] = 'Email';
$fields['S_Street']['text'] = 'Street';
$fields['S_Suburb']['text'] = 'Suburb';
$fields['S_City']['text'] = 'City';
$fields['S_ID']['hidden'] = '';

if (array_key_exists('id', $_REQUEST) && $_REQUEST['id'] != '') 
{
	$bizLayer = new SupplierBiz();
	
	$data = $bizLayer->getSupplierByID($_REQUEST['id']);
	$formAction .= '&id=' . $_REQUEST['id'];
	$guide .= '<p>The Supplier ID is: ' . $_REQUEST['id'] ;
	
}

$form = new Form('people.png', 'Supplier Form', $guide, $fields, $data, 'Supplier', $formAction, 'Submit', '');
$cont .= $form->render();

$thePage = new PageAdmin('Manage Suppliers | Quality Cars', '', $cont);
array_push($thePage->cssSources, 'forms.css');
array_push($thePage->jsSources, 'form.js');
array_push($thePage->jsSources, 'supplier.js');
echo $thePage->render();

?>