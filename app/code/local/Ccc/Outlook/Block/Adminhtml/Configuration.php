<?php
class Ccc_Outlook_Block_Adminhtml_Configuration extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_configuration';
        $this->_blockGroup = 'ccc_outlook';
        $this->_headerText = Mage::helper('ccc_outlook')->__('Outlook Configuration');
        $this->_addButtonLabel = Mage::helper('ccc_outlook')->__('Add Configuration');
        parent::__construct();
    }
}
