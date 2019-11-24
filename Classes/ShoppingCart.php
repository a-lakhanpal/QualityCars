<?php
/** a class that handles all Shopping Cart functionality **/

class ShoppingCart {
	
	/** Clears the shopping cart **/
	static function clear() 
	{
		unset($_SESSION['ShoppingCart']);		
	}


	/** add a car to the shopping cart (session variable: ShoppingCart) **/
	static function add($carID)
	{
		if (array_key_exists('ShoppingCart', $_SESSION))
		{
			array_push($_SESSION['ShoppingCart'], $carID);
		} else {
			$_SESSION['ShoppingCart'] = array($carID);
		}			 
		
	}

	/** render shopping cart items **/
	static function renderItems() 
	{
		if (!isset($_SESSION['ShoppingCart']) || empty($_SESSION['ShoppingCart'])) //if there is nothing in shopping cart
		{
				$output = '<div style="text-align:center; padding: 10px; width:100%;">Shopping Cart is Empty</div>';
		} else {
				
				//make an array with quantity of each car: $cars[car id] = quantity
				$cars = array();
				foreach($_SESSION['ShoppingCart'] as $carID)
				{
					if (array_key_exists($carID, $cars)) {	
						$cars[$carID] += 1;
					} else {
						$cars[$carID] = 1;
					}
				}
				
				$CTData = new CarTypeBiz();
			
				$output = '<ul>';
				$totalPrice = 0;
				
				foreach($cars as $cid => $qty)
				{
					$row = $CTData->getCarTypeByID($cid);
					$output .= '<li>' . ' ' . $row['CT_Make'] . ' ' . $row['CT_Model'] . ' '. $row['CT_Year'] . '<br />'. $qty . ' x ' . number_format($row['CT_Price']) .'</li>';
					
					$totalPrice += $row['CT_Price'] * $qty;
				
				}
				
				$output .= '</ul>';
				
				$output .= '<ul class="totals">';
				$output .= '<li>subtotal: ' . number_format($totalPrice) . '</li>';
				$output .= '<li>GST (12.5%): ' . number_format($totalPrice * .125) . '</li>';
				$output .= '<li><string>total: '. number_format($totalPrice + ($totalPrice * .125)) .'</strong></li>';
				$output .= '</ul>';
				
				$output .= '<div>';
				$suf = (array_key_exists('id', $_REQUEST)) ? '&id=' . $_REQUEST['id'] : '';
				$output .= '<a href="' . $_SERVER['PHP_SELF'] . '?action=ClearCart'. $suf .'">clear</a>';
				$output .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.APP_URI.'Orders.php?action=checkout">checkout</a>';
				$output .= '</div>';
		}
		
		return $output;
	}
	
	//make an array with quantity of each car: $cars[car id] = quantity
	static function getAddedCars()
	{
			//make an array with quantity of each car: $cars[car id] = quantity
			$cars = array();
			foreach($_SESSION['ShoppingCart'] as $carID)
			{
				if (array_key_exists($carID, $cars)) {	
					$cars[$carID] += 1;
				} else {
					$cars[$carID] = 1;
				}
			}
			return $cars;
	}
	
}


?>