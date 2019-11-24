<?php
/** data layer class for Supplier records **/

require_once('DataManager.php');

class SupplierData extends DataManager
{

	function __construct()
	{
		parent::__construct('QC_Supplier', array('S_ID', 'S_Name', 'S_PhoneHome', 'S_PhoneWork', 'S_PhoneMobile', 'S_Fax', 'S_Email', 'S_Street', 'S_Suburb', 'S_City'), 'S_ID');
	}
	
}
?>