<?php
class Ccc_Orderstock_Block_Adminhtml_Orderstock extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_orderstock';
        $this->_blockGroup = 'orderstock';
        $this->_headerText = Mage::helper('orderstock')->__('Manufacturer');
        $this->_addButtonLabel = Mage::helper('orderstock')->__('Add New Manufacturer');
        parent::__construct();
    }
}
