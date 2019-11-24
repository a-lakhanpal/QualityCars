<?php
ob_start();
session_start();

/** The class that builds master page **/
include('Page.php');

class PageAdmin extends Page
{
	
	var $adminCont;

	function __construct($title, $activeMenu, $cont)
	{
		if (!array_key_exists('UserType', $_SESSION) || $_SESSION['UserType'] != 'Admin') {
			trigger_error("You must be logged in as Administrator to be able to view the admin section!");	
		}
		
		$this->adminCont = $cont;
		
		parent::__construct($title, $activeMenu, $this->genAdminCont());
		array_push($this->cssSources, 'admin.css');
	}
	
	
	/** generate admin contents **/
	private function genAdminCont()
	{
		
		$output = '<div class="innerContent">'.$this->adminCont.'</div>';
	
			
		return $output;
	}
}


?>