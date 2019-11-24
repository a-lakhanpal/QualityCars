<?php
/** data layer class for user records **/

require_once('DataManager.php');

class UserData extends DataManager
{

	function __construct()
	{
		parent::__construct('QC_User', array('U_ID', 'U_FirstName', 'U_LastName', 'U_PhoneHome', 'U_PhoneWork', 'U_PhoneMobile', 'U_Fax', 'U_Email', 'U_Password', 'U_Street', 'U_Suburb', 'U_City', 'U_Status'), 'U_ID');
	}
	
	/** 
	  * given a user name and password checks and retrieves the user record
	  * @param email: email
	  * @param password: password
	  * @return associative array of user information or false if no matching record exist
	 **/
	function validateUser($email, $password)
	{
		$conn = odbc_connect('soltab01database1', '', '');
		$sql = "SELECT * FROM $this->table WHERE (U_Email = '$email' AND U_Password = '$password')";
		$rs = odbc_exec($conn, $sql);
		
		$output = array();
		$row = odbc_fetch_array($rs);
		
		odbc_close($conn);
		
		return $row;
		
	}
	
}
?>