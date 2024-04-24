<?php
class Ccc_Orderstatus_Block_Adminhtml_Orderstatus extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_orderstatus';
        $this->_blockGroup = 'ccc_orderstatus';
        $this->_headerText = Mage::helper('ccc_orderstatus')->__('Orderstatus');
        $this->_addButtonLabel = Mage::helper('ccc_orderstatus')->__('Add New orderstatus');
        parent::__construct();
    }
}
