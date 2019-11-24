<?php
/** Business Layer class for Supplier data table **/
require_once(APP_ROOT.'DataLayer/SupplierData.php');

class SupplierBiz
{
	var $dataClass;
	
	function __construct()
	{
		$this->dataClass = new SupplierData();	
	}
	
	/**
	 * function to get all Suppliers
	 **/
	 function getAllSuppliers()
	 {
		return $this->dataClass->getAllRecords(); 
	 }
	 
	 /** get a single record by id **/
	 function getSupplierByID($id)
	 {
		 return $this->dataClass->getRecordByID($id);
	 }
	 
	  /** function to create a Supplier record 
	  * @param $vals: array[field name] = value
	 **/
	 function createSupplier($vals)
	 {
		return $this->dataClass->insertRecord($vals); 
	 }
	 
	  /** function to update a supplier record
	  * @param $vals: array[field name] = value
	 **/
	 function updateSupplier($vals)
	 {
		return $this->dataClass->updateRecord($vals); 
	 }
	 
	 /** function to delete a car type
	  * $param $id: the id of the record to delete
	  **/
	  function deleteSupplier($id)
	  {
		  return $this->dataClass->deleteRecord($id);
	  }
	
}

?>