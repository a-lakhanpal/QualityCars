<?php

/**
  * This is a class that is used to generate simple forms for the application
 **/
 
 class Form
 {
	 
	 var $icon; //name of an image in the Assets/images folder that should be displayed in the form
	 var $title; //the title of the form
	 var $guide; //instrucitons to the users when filling the form
	 var $fields; //a mult-dimentional associative array defining fields: $fields[field name][field type] = field label
	 var $data; //if the form needs to be pre-filled an array of field values: $data[field name] = value
	 var $formName; //the name of the form
	 var $action; //form's action URL
	 var $submitText; //the lable to be display on the submit button
	 var $custom; //custom code to be added before the submit button
	 
	 function __construct($icon, $title, $guide, $fields, $data, $formName, $action, $submitText, $custom)
	 {
		 $this->icon = $icon;
		 $this->title = $title;
		 $this->guide = &$guide;
		 $this->fields = &$fields;
		 $this->data = $data;
		 $this->formName = $formName;
		 $this->action = $action;
		 $this->submitText = $submitText;
		 $this->custom = $custom;
	 }
	 
	 /**
	   * renders the form and a table of fields and everything
	   * @return: html string
	  **/
	  public function render()
	  {
		  
		$output="
			<form name='$this->formName' id='$this->formName' action='$this->action' method='post' enctype=\"multipart/form-data\">
				<table class='fieldsWrapper'>
					<tr>
						<td class='infoPane'>";
		
		//rnder the guide column
		if ($this->icon != '')
		{
			$output .= "<img src='".APP_URI. "Assets/images/$this->icon' />";	
		}
		$output .= "<h3>$this->title</h3>";
		$output .= $this->guide;
		$output .= "</td>
					<td class='fieldsContainer'>";
					
		$output .= "<table class='fields'>";
		//render the field rows
		foreach($this->fields as $field => $type)
		{
			$val = (array_key_exists($field, $this->data)) ? $this->data[$field] : '';
			
			$output .= "<tr>";
			$output .= "<td>";
			$output .= "<label for='$field'>" . current($type) . "</label>";
			$output .= "</td>";
			$output .= "<td>";
			if (key($this->fields[$field]) == 'textarea') 
			{
				$output .= "<textarea name='$field' id='$field'>".$val."</textarea>";
			}
			else 
			{		
				$output .= "<input type='" . key($this->fields[$field]) . "' value='" . $val . "' name='$field' id='$field' />";
			}
			$output .= "</td>";
			$output .= "</tr>";	
		}
		$output .= '<tr><td colspan="2">' . $this->custom . '</td></tr>';
		$output .= '<tr><td>&nbsp;</td><td class="center"><input type="submit" value="' . $this->submitText .  '" class="submit" /></td></tr>';
		$output .= "</table>";


		$output .= "</td></tr></table></form>";

		return $output; 
	  }
	 
	 
 }


?>