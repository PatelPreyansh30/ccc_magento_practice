<?php
class Ccc_Banner_Block_Adminhtml_Banner extends Mage_Adminhtml_Block_Widget_Grid_Container  
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_banner';
        $this->_blockGroup = 'banner';
        $this->_headerText = Mage::helper('banner')->__('Banner');
        $this->_addButtonLabel = Mage::helper('banner')->__('Add New banner');
        parent::__construct();
    }
}
