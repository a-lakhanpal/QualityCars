<?php
/** Business Layer class for CarType data table **/
require_once(APP_ROOT.'DataLayer/CarTypeData.php');

class CarTypeBiz
{
	var $dataClass;
	
	function __construct()
	{
		$this->dataClass = new CarTypeData();	
	}
	
	/**
	 * function to get all car types
	 **/
	 function getAllCarTypes()
	 {
		return $this->dataClass->getAllRecords(); 
	 }
	 
	 /** get a single record by id **/
	 function getCarTypeByID($id)
	 {
		 return $this->dataClass->getRecordByID($id);
	 }
	 
	  /** function to create a car type record 
	  * @param $vals: array[field name] = value
	 **/
	 function createCarType($vals)
	 {
		return $this->dataClass->insertRecord($vals); 
	 }
	 
	  /** function to update a car type record
	  * @param $vals: array[field name] = value
	 **/
	 function updateCarType($vals)
	 {
		return $this->dataClass->updateRecord($vals); 
	 }
	 
	 /** function to delete a car type
	  * $param $id: the id of the record to delete
	  **/
	  function deleteCarType($id)
	  {
		  return $this->dataClass->deleteRecord($id);
	  }
	
}

?>