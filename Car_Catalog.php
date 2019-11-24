<?php
/** Car Catalog page for the Customers **/
require_once('Classes/PageCustomer.php');

$CTData = new CarTypeBiz();
$carTypes = $CTData->getAllCarTypes();

$cont = '<h1>Available car models</h1>';

foreach ($carTypes as $row)
{
	$cont .= '
		<table class="carList">
			<tr>
				<td class="center" rowspan="2">
					<img width="100" src="'.APP_URI. 'DataLayer/Car_images/' . $row['CT_Photo'] . '" />
				</td>
				<td class="carTitle">
					<h3>' . $row["CT_Make"] . ' ' . $row["CT_Model"] .' '.  $row["CT_Year"] .' '. $row["CT_Color"]. '</h3>
				</td>
				<td>' . number_format($row["CT_Price"]) . '(GST exclusive) </td>
			</tr>
			<tr>
				<td>' . $row['CT_Desc'] . '</td>
				<td>
					<a href="'. $_SERVER['PHP_SELF'] . '?action=AddToCart&id=' . $row['CT_ID'] .'">add to cart</a> | 
					<a href="Car_Details.php?id='. $row['CT_ID'] . '">view details</a>
				</td>
			</tr>
		</table>';
}

$thePage = new PageCustomer('Catalog | Quality Cars', 'Car Catalog', $cont);

echo $thePage->render();



?>


