<?php
class Ccc_Reportmanager_Block_Adminhtml_Reportmanager extends Mage_Adminhtml_Block_Widget_Grid_Container  
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_reportmanager';
        $this->_blockGroup = 'ccc_reportmanager';
        $this->_headerText = Mage::helper('ccc_reportmanager')->__('Reportmanager');
        $this->_addButtonLabel = Mage::helper('ccc_reportmanager')->__('Add');
        parent::__construct();
        $this->_removeButton('add');
    }
}
