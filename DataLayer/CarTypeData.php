<?php
/** data layer class for car types **/

require_once('DataManager.php');

class CarTypeData extends DataManager
{

	function __construct()
	{
		parent::__construct('QC_CarType', array('CT_ID', 'CT_Make', 'CT_Model', 'CT_Year', 'CT_Color', 'CT_Price', 'CT_Desc', 'CT_Photo', 'CT_SupplierID'), 'CT_ID');
	}
	
}
?>