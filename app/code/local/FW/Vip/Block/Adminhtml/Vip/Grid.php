<?php

class FW_Vip_Block_Adminhtml_Vip_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('vipGrid');
      $this->setDefaultSort('vip_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('vip/vip')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('vip_id', array(
          'header'    => Mage::helper('vip')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'vip_id',
      ));

      $this->addColumn('product_sku', array(
          'header'    => Mage::helper('vip')->__('Product Sku'),
          'align'     =>'left',
          'index'     => 'product_sku',
      ));

      $customerGroup = Mage::getModel('customer/resource_group_collection');
      
      //Don't show the "NOT LOGGED IN" group as we don't want customers to be mapped to that group.
      $customerGroup->setIgnoreIdFilter(0);
      $groupArray = $customerGroup->toOptionHash();

      $this->addColumn('customer_group_id', array(
          'header'    => Mage::helper('vip')->__('Customer Group Id'),
          'align'     =>'left',
          'index'     => 'customer_group_id',
          'type'      => 'options',
          'options' => $groupArray,
      ));
	  
      $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('vip')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('vip')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		//$this->addExportType('*/*/exportCsv', Mage::helper('vip')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('vip')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('vip_id');
        $this->getMassactionBlock()->setFormFieldName('vip');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('vip')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('vip')->__('Are you sure?')
        ));

        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}