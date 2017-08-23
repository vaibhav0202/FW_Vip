<?php

class FW_Vip_Block_Adminhtml_Vip_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('vip_form', array('legend'=>Mage::helper('vip')->__('Rule information')));
     
      $fieldset->addField('product_sku', 'text', array(
          'label'     => Mage::helper('vip')->__('Sku'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'product_sku',
      ));

      /*$fieldset->addField('cust_group', 'text', array(
          'label'     => Mage::helper('vip')->__('Customer Group Id'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'cust_group',
      ));*/

      $customerGroup = Mage::getModel('customer/resource_group_collection');
      
      //Don't show the "NOT LOGGED IN" group as we don't want customers to be mapped to that group.
      $customerGroup->setIgnoreIdFilter(0);
      $groupArray = $customerGroup->toOptionArray();

      $fieldset->addField('customer_group_id', 'select', array(
            'label'     => Mage::helper('vip')->__('Customer Group'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'customer_group_id',
            'values'    => $groupArray,
      ));

      if ( Mage::getSingleton('adminhtml/session')->getVipData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getVipData());
          Mage::getSingleton('adminhtml/session')->setVipData(null);
      } elseif ( Mage::registry('vip_data') ) {
          $form->setValues(Mage::registry('vip_data')->getData());
      }
      return parent::_prepareForm();
  }
}