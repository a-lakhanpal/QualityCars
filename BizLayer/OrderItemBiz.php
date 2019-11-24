<?php
/** Business Layer class for Orders table **/
require_once(APP_ROOT.'DataLayer\\OrderItemData.php');

class OrderItemBiz
{
	var $dataClass;
	
	function __construct()
	{
		$this->dataClass = new OrderItemData();	
	}
	
	/**
	 * function to get all order items
	 **/
	 function getAllOrderItems()
	 {
		return $this->dataClass->getAllRecords(); 
	 }
	 
	 /** get a single order items by id **/
	 function getOrderItemByID($id)
	 {
		 return $this->dataClass->getRecordByID($id);
	 }
	 
	 /**
	 * get order items by order id
	 **/
	 function getOrderItemsByOrder($orderID)
	 {
		 return $this->dataClass->getItemsByOrder($orderID);
	 }
	 
	 
	 /** function to create an order item record
	  * @param $vals: array[field name] = value
	 **/
	 function createOrderItem($vals)
	 {
		$this->dataClass->insertRecord($vals); 
	 }
	 
	  /** function to update order item record
	  * @param $vals: array[field name] = value
	 **/
	 function updateOrderItem($vals)
	 {
		$this->dataClass->updateRecord($vals); 
	 }
	
}

?>