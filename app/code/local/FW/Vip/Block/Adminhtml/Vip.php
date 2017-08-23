<?php
class FW_Vip_Block_Adminhtml_Vip extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_vip';
    $this->_blockGroup = 'vip';
    $this->_headerText = Mage::helper('vip')->__('VIP Customer Program');
    $this->_addButtonLabel = Mage::helper('vip')->__('Add Rule');
    parent::__construct();
  }
}