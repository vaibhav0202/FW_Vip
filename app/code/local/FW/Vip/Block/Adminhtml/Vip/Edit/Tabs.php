<?php

class FW_Vip_Block_Adminhtml_Vip_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('vip_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('vip')->__('VIP Customer Program Rule'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('vip')->__('Rule Information'),
          'title'     => Mage::helper('vip')->__('Rule Information'),
          'content'   => $this->getLayout()->createBlock('vip/adminhtml_vip_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}