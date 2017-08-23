<?php

class FW_Vip_Model_Mysql4_Vip extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('vip/vip', 'vip_id');
    }
}