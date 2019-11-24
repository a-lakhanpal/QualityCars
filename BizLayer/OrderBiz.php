<?php
/** Business Layer class for Orders table **/
require_once(APP_ROOT.'DataLayer\\OrderData.php');

class OrderBiz
{
	var $dataClass;
	
	function __construct()
	{
		$this->dataClass = new OrderData();	
	}
	
	/**
	 * function to get all orders
	 **/
	 function getAllOrders()
	 {
		return $this->dataClass->getAllRecords(); 
	 }
	 
	 /** get a single order by id **/
	 function getOrderByID($id)
	 {
		 return $this->dataClass->getRecordByID($id);
	 }
	 
	 /**
	 * get orders by customer
	 **/
	 function getOrdersByCustomer($customerID)
	 {
		 return $this->dataClass->getOrdersByCustomer($customerID);
	 }
	 
	 
	 /** function to create an order record
	  * @param $vals: array[field name] = value
	 **/
	 function createOrder($vals)
	 {
		return $this->dataClass->insertRecord($vals); 
	 }
	 
	  /** function to update order record
	  * @param $vals: array[field name] = value
	 **/
	 function updateOrder($vals)
	 {
		return $this->dataClass->updateRecord($vals); 
	 }
	 
	 /** get the id of the last record **/
	 function getLastID()
	 {
		 return $this->dataClass->getLastID();
	 }
		 
	
}

?>