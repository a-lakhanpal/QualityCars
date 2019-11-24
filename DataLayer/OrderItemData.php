<?php
/** data layer class for Order Item records **/

require_once('DataManager.php');

class OrderItemData extends DataManager
{

	function __construct()
	{
		parent::__construct('QC_OrderItem', array('OI_ID', 'OI_Quantity', 'OI_Price', 'OI_TotalCost', 'OI_CarTypeID', 'OI_OrderID'), 'OI_ID');
	}
	
	
	/** function to retrieve list of order items by order id
	  * @param order =order id
	  * returns a multi-dimensional array of data: array [row number][field name] = data
	 **/
	function getItemsByOrder($orderID)
	{
		$conn = odbc_connect('soltab01database1', '', '');
		
		$sql = "SELECT * FROM $this->table WHERE OI_OrderID = " . $orderID;
	
		$rs	= odbc_exec($conn, $sql);
		
		$output = array();
		
		while (odbc_fetch_row($rs))
		{
			$rec = array();
			foreach ($this->fields as $field) 
			{
				$rec[$field] = odbc_result($rs, $field);	
			}
			array_push($output, $rec);
		}
		return $output;
		odbc_close($conn);
	}
	
	
}
?>