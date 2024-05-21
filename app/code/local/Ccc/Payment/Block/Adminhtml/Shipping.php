<?php
class Ccc_Payment_Block_Adminhtml_Shipping extends Mage_Adminhtml_Block_Widget_Grid_Container  
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_shipping';
        $this->_blockGroup = 'ccc_payment';
        $this->_headerText = Mage::helper('ccc_payment')->__('Shipping Method');
        // $this->_addButtonLabel = Mage::helper('ccc_payment')->__('Add New Shipping Charge');
        parent::__construct();
        $this->_removeButton('add');
    }
}
