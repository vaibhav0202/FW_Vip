<?php

class FW_Vip_Model_Vip extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('vip/vip');
    }
    
    public function processVIPActions($order){
    		//LOAD CUSTOMER MAGE MODEL
    		$customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
    			
    		//Grabs the customer group id that is associated with any of the items in the cart.
    		//Customers could only belong to one customer group, so this function grabs the first vip product in the cart and returns the
    		//customer group id
    		$vipGroupId = $this->getCustomerGroupIdForVip($order->getAllItems());
    			
    		if($vipGroupId != false) {
    			//Add the customer to the vip group and save if a vip product was found
    			$customer->setGroupId($vipGroupId)->save();
    		}
    }
    
    //Grabs the customer group id if there is a VIP item in the cart
    //Customers could only belong to one customer group, so this function grabs the first vip product in the cart and returns the
    private function getCustomerGroupIdForVip($items) {
    	$customerGroupId = false;
    
    	foreach($items as $item) {
    		//Look for a vip mapping with the current sku
    		$vip = Mage::getModel('vip/vip')->loadBySku($item->getSku());
    		//If mapping found, then that means it's a VIP product and has a customer group associated with it.
    		if($vip != false) {
    			//set the return variable to the customer group id
    			$customerGroupId = $vip->getCustomerGroupId();
    			break;
    		}
    	}
    	return $customerGroupId;
    }
    
    //Loads Vip object by sku since that's the only identifier we'll have in the cart
    public function loadBySku($sku)
    {
        $collection = $this->getCollection()
            ->addFilter('product_sku', $sku);
		
        foreach ($collection as $object) {
            return $object;
        }
        return false;
    }    
}