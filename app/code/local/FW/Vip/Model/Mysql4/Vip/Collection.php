<?php

class FW_Vip_Model_Mysql4_Vip_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('vip/vip');
    }
}