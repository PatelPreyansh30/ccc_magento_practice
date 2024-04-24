<?php
class Ccc_Orderstatus_Block_Adminhtml_Orderstatus extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_orderstatus';
        $this->_blockGroup = 'orderstatus';
        $this->_headerText = Mage::helper('orderstatus')->__('Orderstatus');
        $this->_addButtonLabel = Mage::helper('orderstatus')->__('Add New orderstatus');
        parent::__construct();
    }
}
