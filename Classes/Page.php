<?php
ob_start();
session_start();

date_default_timezone_set('Pacific/Auckland');
/**
* This class is an abstract class that construct the basic main HTML for all pages in this application.
* Other page types e.g. Customer Page and Admin Page derive from this class
**/

//the application root that can be used as path prefix"
define("APP_ROOT", $_SERVER['DOCUMENT_ROOT'] . "\\wad10s1\\soltab01\\QualityCarsPHP\\");
define("APP_URI", "/wad10s1/soltab01/QualityCarsPHP/");

//include globals
require_once( APP_ROOT . 'Includes\Globals.php');

class Page 
{
	var $title = "A Quality Cars Page"; //the page title
	var $cssSources = array(); //sources of css files to be linked to the page - path should be relative to Assets/css
	var $jsSources = array(); //sources of js files to be linked to the page - path should be relative to Assets/js
	var $customHeadCode; //custom code that be inserted under <head>
	var $content; //the content of the page
	var $curMenu; //the name of the menu item that should be highlighted to show the current page
	
	/**
	* The constractor
	* @param $title: String - the page title
	* @param $activeMenu: Sring - the menu item that should have the 'current' css class
	**/
	public function __construct($title, $activeMenu, $cont) 
	{
		$this->title = $title;
		$this->curMenu = $activeMenu;
		$this->content = $cont;
		
		//link the global css
		array_push($this->cssSources, 'global.css');
		
		//link jquery javascript
		array_push($this->jsSources, 'jquery.js');

	}
	
	/**
	* Renders html for the page
	**/
	public function &render() 
	{
		$output = <<<HERE
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
HERE;

		$output .= $this->genHTMLHead();
		$output .= '<body>';
		$output .= $this->genPageHeader();	
		$output .= $this->genMenu();
		$output .= '<div id="mainContent">' . $this->content ;
		
		if (array_key_exists('UserType', $_SESSION) && $_SESSION['UserType'] == 'Admin')  {
			$output .= $this->genAdminMenu();	
		}
		
		$output .= '</div>';
		$output .= '</body>';
		$output .= '</html>';
	
		return $output;
	}
	
	
	/**
	* Generates the HTML <head> tage of the page
	**/
	private function &genHTMLHead() 
	{
		$output = '<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		$output .=	"<title>$this->title</title>";
		$output .= $this->customHeadCode;
			//add css links
		foreach ($this->cssSources as $css) 
		{
			$output .= '<link href="'.APP_URI.'Assets/css/'.$css.'" type="text/css" rel="stylesheet" />';
		}
		
		//add js links
		foreach ($this->jsSources as $js)
		{
			$output .= '<script type="text/javascript" src="'.APP_URI.'Assets/js/'.$js.'"></script>';	
		}
		
		//add the custom head code
		$output .= "</head>";
	
		return $output;
	}
	
	
	/**
	* Generates the page header section 
	**/	
	private function &genPageHeader()
	{
		$output = '<div id="header">
						<img src="' . APP_URI . 'Assets/images/logo.png" />
						<h1><a href="' . APP_URI . '">Quality Cars</a></h1>';	
		$output .= '</div>';
		
		return $output;
	}
	
	
	/** Generate the menu **/
	private function &genMenu() 
	{
		if ( array_key_exists('UserType', $_SESSION) && $_SESSION['UserType'] !== '' )
		{
			if ($_SESSION['UserType'] == 'Customer') //if a customer is logged in
			{
				$items = array('Home', 'Car Catalog', 'My Profile', 'My Orders', 'Contact us', 'About us', 'Log out');
			} 
			else if ($_SESSION['UserType'] == 'Admin') //if admin is logged in
			{
				$items = array('Home', 'Car Catalog', 'Contact us', 'About us', 'Log out');
			}
		}
		else  //if no one is logged in
		{
			$items = array('Home', 'Car Catalog', 'Register', 'Contact us', 'About us', 'Log in');
		}
		
		$output = '<div id="menu"><ul>';
		
		foreach ($items as $it)
			{
				$class = ($this->curMenu == $it) ? "class='current'" : "";
				
				$output .= "<li $class>" . $this->getMenuLink($it);
				
				$output .= '</li>';
			}
		
		$output .= '</ul></div>';
		
		return $output;
	}
	
	//given a menu item name returns the <a> tag for it with correct link
	private function getMenuLink($it) 
	{
		switch($it) 
		{
			case "Home" :
				$output = "<a href=\"" . APP_URI . "index.php\">$it</a>";
				break;
				
			case "Log out" :
				$output = "<a href=\"" . APP_URI . "Log_in.php?action=logout\">$it</a>";
				break;
				
			case "My Profile" :
				$uid = $_SESSION['User']['U_ID'];
				$output = "<a href=\"" . APP_URI . "Register.php?id=$uid\">$it</a>";
				break;
				
			case "Customer Error Log" :
				$output = "<a href=\"" . APP_URI . "Error_Log.txt\">$it</a>";
				break;
			
			case "Admin Error Log" :
				$output = "<a href=\"" . APP_URI . "Admin/Error_Log.txt\">$it</a>";
				break;
				
			case "Manage Car Types" :
				$output = "<a href=\"" . APP_URI . "Admin/CarTypes.php\">$it</a>";
				break;
				
			case "Manage Supplier" :
				$output = "<a href=\"" . APP_URI . "Admin/Suppliers.php\">$it</a>";
				break;
				
			case "Manage Customers" :
				$output = "<a href=\"" . APP_URI . "Admin/Customers.php\">$it</a>";
				break;
				
			case "My Orders" :
				$output = "<a href=\"" . APP_URI . "Orders.php\">$it</a>";
				break;
				
			case "Manage Orders" :
				$output = "<a href=\"" . APP_URI . "Admin/Orders.php\">$it</a>";
				break;
				
			default: 
				$output = "<a href=\"" . APP_URI .  str_replace(" ", "_", $it) . ".php\">$it</a>";
				break;
		}
		
		return $output;
	}
	
	
	/**
	 * generate admin menu
	 **/
	function genAdminMenu()
	{
		$items = array('Manage Car Types', 'Manage Supplier', 'Manage Customers', 'Manage Orders', 'Sep', 'Customer Error Log', 'Admin Error Log');	
	
		$output = '<div class="sideBar">
					<h2>Admin menu</h2>
						<div class="sbInner">
							<ul>';
							foreach ($items as $item)
							{
								$output .= '<li>';
								$output .= ($item != 'Sep') ? $this->getMenuLink($item) : '&nbsp;';
								$output .= '</li>';
							}
		$output .= 		' </ul>
						 </div>
						<div class="sbBottom"></div>
				   </div>';
				   
		return $output;
	
	}
	
}



?>