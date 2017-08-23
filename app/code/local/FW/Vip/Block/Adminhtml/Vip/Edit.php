<?php

class FW_Vip_Block_Adminhtml_Vip_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'vip';
        $this->_controller = 'adminhtml_vip';
        
        $this->_updateButton('save', 'label', Mage::helper('vip')->__('Save Rule'));
        $this->_updateButton('delete', 'label', Mage::helper('vip')->__('Delete Rule'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('vip_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'vip_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'vip_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('vip_data') && Mage::registry('vip_data')->getId() ) {
            return Mage::helper('vip')->__("Edit Rule '%s'", $this->htmlEscape(Mage::registry('vip_data')->getSku()));
        } else {
            return Mage::helper('vip')->__('Add Rule');
        }
    }
}