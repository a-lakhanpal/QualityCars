<?php
/** Shows the details of an order
expects teh order id in request var: id **/
require_once('Classes/PageCustomer.php');
require_once('BizLayer/OrderBiz.php');
require_once('BizLayer/OrderItemBiz.php');
require_once('BizLayer/CarTypeBiz.php');

$cont = '';

$orderData = new OrderBiz();
$orderItemData = new OrderItemBiz();
$carTypeData = new CarTypeBiz();

$user = $_SESSION['User'];
$order = $orderData->getOrderByID($_REQUEST['id']);
$items = $orderItemData->getOrderItemsByOrder($order['O_ID']);

$cont .= '<table class="orderDetails">
			<tr>
				<td colspan="2"><h2>TAX INVOICE</h2></td>
				<td rowspan="2"><strong>'.$user['U_FirstName'].' '.$user['U_LastName'].'</strong><br />'.
				$user['U_Street'].'<br />'.$user['U_Suburb'].'<br />'.$user['U_City'].'<br />'.$user['U_PhoneWork'].
				'<tr><td>Date: '.$order['O_OrderDate'].'</td><td>Status: '.$order['O_Status'].'</td><tr><td colspan="3" class="oiContainer">';
//order items
$cont .= '<table class="orderItems">
			<tr><th>No</th><th>Description</th><th>Quantity</th><th>Price</th><th>Cost</th></tr>';
			$count = 1;
			foreach ($items as $item)
			{
				$car = $carTypeData->getCarTypeByID($item['OI_CarTypeID']);
				$cont .= '<tr>';
				$cont .= '<td>'.$count.'</td>';
				$cont .= '<td>'.$car['CT_Make'].' '.$car['CT_Model'].' '.$car['CT_Year'].' '.$car['CT_Color'].'<br /><small>'.$car['CT_Desc'].'</small></td>';
				$cont .= '<td>'.number_format($item['OI_Quantity'], 0).'</td>';
				$cont .= '<td>'.number_format($item['OI_Price']).'</td>';
				$cont .= '<td>'.number_format($item['OI_TotalCost']).'</td>';				
				$cont .= '</tr>';	
				$count += 1;
			}
$cont .= '</table>';
			
$cont .= '</td></tr>
			<tr><td>Sub-total: '.number_format($order['O_SubTotal']).'</td><td>GST: '.number_format($order['O_GST']).'</td><td>Grand Total: '.number_format($order['O_GrandTotal']).'</td></tr>
			</table>';


$thePage = new PageCustomer('Order Details | Quality Cars', 'My Orders', $cont);
array_push($thePage->cssSources, 'orderDetails.css');
echo $thePage->render();



?>


