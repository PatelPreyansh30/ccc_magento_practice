<?php
class Ccc_Template_Block_Adminhtml_Template extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_template';
        $this->_blockGroup = 'ccc_template';
        $this->_headerText = Mage::helper('ccc_template')->__('Exception Template');
        $this->_addButtonLabel = Mage::helper('ccc_template')->__('Add Exception Template');
        parent::__construct();
    }
}
