<?

/** Page displaying details of a single car **/
require_once('Classes/PageCustomer.php');

$CTData = new CarTypeBiz();
$row = $CTData->getCarTypeByID($_REQUEST['id']);

$cont = '<h1>' . $row["CT_Make"] . ' ' . $row["CT_Model"] .' '.  $row["CT_Year"] .' '. $row["CT_Color"] . '</h1>';

$cont .= '<table class="carDetails">
			<tr>
				<td><img width="400" src="'.APP_URI. 'DataLayer/Car_images/' . $row['CT_Photo'] . '" /></td>
				<td>
					<ul>
						<li>ID: ' . $row['CT_ID'] . '</li>
						<li>Make: '. $row['CT_Make'] . '</li>
						<li>Model: '. $row['CT_Model']. '</li>
						<li>Year: ' . $row['CT_Year']. '</li>
						<li>Color: ' . $row['CT_Color']. '</li>
						<li>Price: '. number_format($row['CT_Price']). '</li>
						<li>Description: '. $row['CT_Desc']. '</li>
						<li><a href="'. $_SERVER['PHP_SELF'] . '?action=AddToCart&id=' . $row['CT_ID'] .'">add to cart</a>
					</ul>
				</td>
			</tr>
		 </table>';

$thePage = new PageCustomer('Car Details | Quality Cars', 'Car Catalog', $cont);

echo $thePage->render();

?>