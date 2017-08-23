<?php 

class FW_Vip_Model_Observer {
	
	public function hookToOrderSuccessEvent($observer)
	{
		//GET ORDER IDs
		$orderIds = $observer->getOrderIds();
		
		if (!empty($orderIds) && is_array($orderIds))
		{		
			foreach ($orderIds as $oid){			
				$groupArray = array();
		
				//$order = $observer->getEvent()->getOrder();
				//LOAD ORDER MAGE MODEL
				$order = Mage::getSingleton('sales/order');
				//$_order = Mage::getModel('sales/order')->load($oid); 

				if ($order->getId() != $oid) $order->reset()->load($oid);
				
				Mage::getModel('vip/vip')->processVIPActions($order);
			}
		} 
	}

	//This function is called when the paypal auto complete observer is run on failed Paypal orders
	public function completeFailedOrderSuccessEvent($observer)
	{
		//GET ORDER
		$order = $observer->getOrder();
		Mage::getModel('vip/vip')->processVIPActions($order);
	}

	//This function is called when a user browses to the checkout page as a guest.
    public function checkForVipItems($observer) {
    	//Grab all the items in the cart
    	$items  = $observer->getEvent()->getQuote()->getAllItems();
    	$cartHasVipItem = false;
    	$vipItemsInCart = array();
    	//Loop through each item to see if it's a VIP item or not.
    	foreach($items as $item) {
    		//Grab the vip mapping for the sku if one exists.
    		$vip = Mage::getModel('vip/vip')->loadBySku($item->getSku());
    		if($vip != false) {
    			//If the vip mapping exists, add the name to the vipItems array for proper message display.
    			$vipItemsInCart[] = $item->getName();
    			$cartHasVipItem = true;
    		}
    	}
    	//If the cart has a VIP item in it, create error message and redirect user to the login page which allows them to login or register.
    	if($cartHasVipItem && !Mage::getSingleton('customer/session')->IsLoggedIn()) {
    		//Grab the customer session
    		$session = Mage::getSingleton('customer/session');
    			
    		//Set the error message.
    		$message = "The product(s) " . implode(", ", $vipItemsInCart) . " cannot be purchased using Checkout as Guest. Please login or register.";
    			
    		//Add the message to an array and call $session->addUniqueMessages($messageArray).  For some reason this event is triggered
    		//more than once, and if you just use $session->addError($message), it will display the error on the login page multiple times.
    		$messageArray[] = Mage::getSingleton('core/message')->error($message);
    		$session->addUniqueMessages($messageArray);
    			
    		//Redirect the guest user to the login page.
    		Mage::app()->getResponse()->setRedirect(Mage::getUrl("customer/account/login"));
    	}
    }
}
