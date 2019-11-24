<?php

/** the class is used to render a customer page **/
require_once("Page.php");
require_once("ShoppingCart.php");
require_once('BizLayer/CarTypeBiz.php');


class PageCustomer extends Page
{
	var $customerContent;
	
	//constructor
	public function __construct($title, $activeMenu, $custContent) 
	{	
		//handle action if there is any requested
		if (isset($_REQUEST['action'])) {
			$this->handleActions($_REQUEST['action']);
		}
		
		$this->customerContent = $custContent;
	
		//link the customer pages css
		array_push($this->cssSources, 'customer.css' );
		
		if (array_key_exists('UserType', $_SESSION) && $_SESSION['UserType'] == 'Admin') {
			array_push($this->cssSources, 'admin.css');	
		}
		
		parent::__construct($title, $activeMenu, $this->genCustContent());
		
	
	}
	
	
	/** generate customer contents **/
	private function genCustContent()
	{
		
		$output = '<div class="innerContent">'.$this->customerContent.'</div>';
		
		if (!array_key_exists('UserType', $_SESSION) || $_SESSION['UserType'] != 'Admin') 
		{
			$output .= $this->genShopCart();
		}
			
		return $output;
	}
	
	
	/** Generates the shopping cart box **/
	private function &genShopCart()
	{
		$output = '<div class="sideBar">
					<h2>shopping cart</h2>
						<div class="sbInner">'.
						ShoppingCart::renderItems()
						.'</div>
						<div class="sbBottom"></div>
				   </div>';
				   
		return $output;
	}
	
	
	/** handle the common actions of the customer page **/
	private function handleActions($action)
	{
		switch ($action) 
		{
			case 'ClearCart' :
				ShoppingCart::clear();
				break;
				
			case 'AddToCart' :
				ShoppingCart::add($_REQUEST['id']);
				break;
				
		}
			
					
	}
		
	
}



?>