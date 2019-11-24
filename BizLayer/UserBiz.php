<?php
/** Business Layer class for User data table **/
require_once(APP_ROOT.'DataLayer\\UserData.php');

class UserBiz
{
	var $dataClass;
	
	function __construct()
	{
		$this->dataClass = new UserData();	
	}
	
	/**
	 * function to get all users
	 **/
	 function getAllUsers()
	 {
		return $this->dataClass->getAllRecords(); 
	 }
	 
	 /** get a single record by id **/
	 function getUserByID($id)
	 {
		 return $this->dataClass->getRecordByID($id);
	 }
	 
	 /** function to vlaidate user **/
	 function validateUser($email, $pass)
	 {
		return $this->dataClass->validateUser($email, $pass); 
	 }
	 
	 /** function to create a user record 
	  * @param $vals: array[field name] = value
	 **/
	 function createUser($vals)
	 {
		$this->dataClass->insertRecord($vals); 
	 }
	 
	  /** function to update user record
	  * @param $vals: array[field name] = value
	 **/
	 function updateUser($vals)
	 {
		$this->dataClass->updateRecord($vals); 
	 }
	
}

?>