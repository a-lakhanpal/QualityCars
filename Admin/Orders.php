<?php
require_once('../Classes/PageAdmin.php');
require_once('../BizLayer/OrderBiz.php');
require_once('../Classes/DataGrid.php');
$orderBiz = new OrderBiz();

$pageContent = "<h1>Manage Orders</h1>";

//handle toggle status if requested if requested
$action = (array_key_exists('action', $_REQUEST)) ? $_REQUEST['action'] : '';
if ($action == 'status') 
{
	$order = $orderBiz->getOrderByID($_REQUEST['id']);
	
	if ($order['O_Status'] == 'Waiting')
	{
		$post = array('O_Status' => 'Shipped', 'O_ID' => $_REQUEST['id']);
	} 
	else if ($order['O_Status'] == 'Shipped')
	{
		$post = array('O_Status' => 'Waiting', 'O_ID' => $_REQUEST['id']);
	} 
	else 
	{
		$post = array('O_Status' => 'Waiting', 'O_ID' => $_REQUEST['id']);
	}
	
	if ($orderBiz->updateOrder($post) !== false ) 
	{
		$pageContent .= '<p class="success">The Order Status was successfully updated.</p>';
	} else {
		$pageContent .= '<p class="error">Failed to update the Order Status!</p>';
	}
}

$orders = $orderBiz->getAllOrders();

//fields to display in datagrid
$cols = array(
	'O_ID' => 'ID',
	'O_OrderDate' => 'Date',
	'O_SubTotal' => 'Sub-total',
	'O_GST' => 'GST',
	'O_GrandTotal' => 'Grand Total',
	'O_CustomerID' => 'Customer ID',
	'O_Status' => 'Status'
	);
	
//custom button to waiting/shipped  status of the order
$custCol = array( "waiting/shipped" =>
	$_SERVER['PHP_SELF'] . "?action=status&id="
	);

$dg = new DataGrid($cols, 'O_ID', $orders, '', '', $custCol);

$pageContent .= $dg->render();


$thePage = new pageAdmin('Manage Orders | Quality Cars', 'Manage Orders', $pageContent);
echo $thePage->render();


?>