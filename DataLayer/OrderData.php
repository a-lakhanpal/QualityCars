<?php
/** data layer class for Order records **/

require_once('DataManager.php');

class OrderData extends DataManager
{

	function __construct()
	{
		parent::__construct('QC_Order', array('O_ID', 'O_OrderDate', 'O_Status', 'O_SubTotal', 'O_GST', 'O_GrandTotal', 'O_CustomerID'), 'O_ID');
	}
	
	
	/** function to retrieve list of orders by Customer
	  * @param custID = customer id
	  * returns a multi-dimensional array of data: array [row number][field name] = data
	 **/
	function getOrdersByCustomer($custID)
	{
		$conn = odbc_connect('soltab01database1', '', '');
		
		$sql = "SELECT * FROM $this->table WHERE O_CustomerID = " . $custID;
	
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