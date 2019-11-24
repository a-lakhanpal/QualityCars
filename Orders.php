<?php
/** List of roders a customer made page
 This page also handles users checking out the shopping cart **/
require_once('Classes/PageCustomer.php');
require_once('BizLayer/OrderBiz.php');
require_once('Classes/DataGrid.php');
require_once('BizLayer/OrderItemBiz.php');
require_once('BizLayer/CarTypeBiz.php');
require_once('Classes/ShoppingCart.php');

$cont = '';

$orderData = new OrderBiz();
$itemData = new OrderItemBiz();
$ctData = new CarTypeBiz();

//handle checkout action if requested
$reqAction = (array_key_exists('action', $_REQUEST)) ? $_REQUEST['action'] : '';
if ($reqAction == 'checkout') 
{
	//ensure the user is logged in
	if (!array_key_exists('UserType', $_SESSION) || $_SESSION['UserType'] != 'Customer')
	{
		header('Location: Log_in.php');	
		exit();
	}
	
	$uid = $_SESSION['User']['U_ID'];
	
	//determine what the new order id would be:
	$newOrderID = $orderData->getLastID() + 1;
	
	$oSubTotal = 0;
	
	$cars = ShoppingCart::getAddedCars();
	
	//add each order item
	foreach($cars as $carID => $qty)
	{
		$car = $ctData->getCarTypeByID($carID);
		$oSubTotal += ($car['CT_Price'] * $qty);
		
		$oi = array( 'OI_Quantity' => $qty,
					'OI_Price' => $car['CT_Price'],
					'OI_TotalCost' => $qty * $car['CT_Price'],
					'OI_CarTypeID' => $carID,
					'OI_OrderID' => $newOrderID
					);
		$itemData->createOrderItem($oi);
	}
	
	 date_default_timezone_set('Pacific/Auckland');
	//add order record
	$order = array(
				'O_OrderDate' => date("Y-m-d"),
				'O_Status' => 'Waiting',
				'O_SubTotal' => $oSubTotal,
				'O_GST' => $oSubTotal * 0.125,
				'O_GrandTotal' => $oSubTotal + ($oSubTotal * 0.125),
				'O_CustomerID' => $uid
				);
				
	$orderData->createOrder($order);
	
	$cont .= '<p class="success">Your order was successfully place!</p>';
	ShoppingCart::clear();
}

$uid = $_SESSION['User']['U_ID'];

$orders = $orderData->getOrdersByCustomer($uid);

$fields = array(
	'O_ID' => 'ID',
	'O_OrderDate' => 'Date',
	'O_Status' => 'Status',
	'O_SubTotal' => 'Sub-total',
	'O_GST' => 'GST',
	'O_GrandTotal' => 'Grand Total'
);

//custom column to view details
$custCol = array('view details' => 'OrderDetails.php?id=');

$dg = new DataGrid($fields, 'O_ID', $orders, '', '', $custCol);


$cont .= '<h1>Your orders so far</h1>';
$cont .= $dg->render();

$thePage = new PageCustomer('Your Orders | Quality Cars', 'My Orders', $cont);
echo $thePage->render();



?>


