<?php

/**
  * This is the master abstract class for all Data Layer classes.
  * It provides general functionality e.g. retrieving  all records or single record for ID.
  * Save a record, etc. 
**/

class DataManager {
	
	var $table; //name of the database table;
	var $fields = array(); //array of fields names in the database
	var $idName; // the name of field containing the ID (primary key) of the recoreds
	var $values; //field values - fill this in if you want to insert or update a record. format: $values[field name] = field value
	
	
	function __construct($table, $fields, $idName)
	{
		$this->table = $table;
		$this->fields = $fields;
		$this->idName = $idName;
	}
	
	
	/**function to get all the records in the given table
	 * returns a multi-dimensional array of data: array [row number][field name] = data
	 **/
	function getAllRecords()
	{
		$conn = odbc_connect('soltab01database1', '', '');
		
		$sql = "SELECT * FROM $this->table";
	
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
	
	
	/** function to retrieve a single record by ID 
	  * returns an associative array of field name => data
	 **/
	function getRecordByID($id)
	{
		$conn = odbc_connect('soltab01database1', '', '');
		$sql = "SELECT * FROM $this->table WHERE $this->idName = $id";
		$rs = odbc_exec($conn, $sql);
		
		$output = array();
		$row = odbc_fetch_row($rs);
		foreach($this->fields as $field)
		{
			$output[$field] = odbc_result($rs, $field);	
		}
		return $output;
		odbc_close($conn);
	}
	
	
	/**
	  * insets a record intot he table
	  * @apram $vals:  the values to put in the record: $vals[field name] = field value
	 **/
	function insertRecord($vals) 
	{
		$conn = odbc_connect('soltab01database1', '', '');
		$sqlfields = '';
		$sqlValues = '';
		
		foreach ($this->fields as $field)
		{
			if ($field != $this->idName) 
			{
				$sqlfields .= "$field, ";
				$sqlValues .= (array_key_exists($field, $vals)) ? "'$vals[$field]', " : "'', ";	
			}
		}
		
		//remove teh last commas
		$sqlfields = substr_replace($sqlfields, "", -2);
		$sqlValues = substr_replace($sqlValues, "", -2);
		
		$sql = "INSERT INTO $this->table ($sqlfields) VALUES ($sqlValues)";
		$rs = odbc_exec($conn, $sql);
		odbc_close($conn);
		return $rs;
		
	}
	
	/**
	  * updates a record into the table
	  * @apram $vals:  the values to put in the record: $vals[field name] = field value
	 **/
	function updateRecord($vals) 
	{
		$conn = odbc_connect('soltab01database1', '', '');
		$sqlfields = '';
		
		foreach ($this->fields as $field)
		{
			if ($field != $this->idName && array_key_exists($field, $vals) && trim($vals[$field]) != '') 
			{
				$sqlfields .= "$field=";
				$sqlfields .= (array_key_exists($field, $vals)) ? "'$vals[$field]'" : '';
				$sqlfields .= ', ';	
			}
		}
		
		//remove teh last comma
		$sqlfields = substr_replace($sqlfields, "", -2);

		
		$sql = "UPDATE $this->table SET $sqlfields WHERE $this->idName = " . $vals[$this->idName];

		
		$rs = odbc_exec($conn, $sql);
		odbc_close($conn);
		return $rs;
		
	}
	
	/**
	 * delete a record by
	 * @param $id: the id of the record to delete
	 **/
	 function deleteRecord($id)
	 {
		 $conn = odbc_connect('soltab01database1', '', '');
		
		$sql = "DELETE FROM $this->table WHERE $this->idName = " . $id;
		
		$rs = odbc_exec($conn, $sql);
		
		return $rs;
	 }
	 
	 /** get the id of the last record **/
	 function getLastID()
	 {
		 $conn = odbc_connect('soltab01database1', '', '');
		$sql = "SELECT MAX($this->idName) FROM $this->table";
		$rs = odbc_exec($conn, $sql);
		
		$output = array();
		$row = odbc_fetch_row($rs);
		return odbc_result($rs, 1);
		odbc_close($conn);
	 }
	
}

?>