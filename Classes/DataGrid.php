<?php
/**
  * This class is used to generate 'DataGrid' a table filled with data from database and provide edit and delete functionality 
  *
 **/
 
 class DataGrid 
 {
	
	var $fields;
	var $idName;
	var $data;
	var $editAction;
	var $deleteAction;
	var $customCols;
	
	/**
	 * Constructor
	 * @param $fields: an array of fields names and their labels: $fields [ field name ] = label 
	 * @param $idName: the field name that is ID (primary key) of the record
	 * @param $data: an multi-dimensional array of data: $data[row number][field name] = data
	 * @param $editAction: if an edit button is required provide the link that the edit button should refer to (id of the record will automatically be added at the end)
	 * @param $deleteAction: if a delete button is required provide the link that the delete button should refer to (id of the record will automatically be added to the end of the link)
	 * @param $custCols: an array of custom columns to be added at the end of the table: $customCols [ column label ] = column value. The column value can use the variable $id as the id of the record
	 **/
	function __construct($fields, $idName, $data, $editAction, $deleteAction, $customCols)
	{
		$this->fields = $fields;
		$this->idName = $idName;
		$this->data = $data;
		$this->editAction = $editAction;
		$this->deleteAction = $deleteAction;
		$this->customCols = $customCols;
	}
	
	
	/**
	 *  build the html table
	 **/
	 private function buildTable()
	 {
		 $output = "<table class='dataGrid'>";
		 
		 //add the header row
		 $output .= "<thead><tr>";
		 foreach ($this->fields as $label)
		 {
			$output .= "<th>$label</th>"; 
		 }
		 $output .= ($this->editAction != '') ? "<th>Edit</th>" : "";
		 $output .= ($this->deleteAction != '') ? "<th>Delete</th>" : "";
		 
		 foreach ($this->customCols as $label => $val)
		 {
			 $output .= "<th>$label</th>";
		 }
		 $output .= "</tr></thead><tbody>";
		 
		 //add data rows
		 foreach ($this->data as $row)
		 {
			 $id = $row[$this->idName];
			 
			$output .= "<tr>";
			foreach($this->fields as $field => $lbl)
			{
				$output .= "<td>$row[$field]</td>";	
			}
				 $output .= ($this->editAction != '') ? "<td class='center'><a href='".$this->editAction.$row[$this->idName]."'><img src='".APP_URI."Assets/images/edit.png' /></a></td>" : "";
		 $output .= ($this->deleteAction != '') ? "<td class='center'><a href='".$this->deleteAction.$row[$this->idName]."'><img src='".APP_URI."Assets/images/delete.png' /></a></td>" : "";
		 
		 	foreach ($this->customCols as $colKey => $colVal)
			{
				
				$output .= "<td><a href='$colVal$id'>$colKey</td>";	
			}
			
			$output .= "</tr>"; 
		 }
	
		 		 
		 $output .= "</tbody></table>";
		 return $output;
	 }
	 
	 
	 function render()
	 {
		return $this->buildTable(); 
	 }
	 
 }
	 
	 
	 
	 
 
 
 
 ?>