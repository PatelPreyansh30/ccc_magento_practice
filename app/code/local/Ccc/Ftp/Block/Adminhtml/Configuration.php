<?php
class Ccc_Ftp_Block_Adminhtml_Configuration extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_configuration';
        $this->_blockGroup = 'ccc_ftp';
        $this->_headerText = Mage::helper('ccc_ftp')->__('FTP Configuration');
        $this->_addButtonLabel = Mage::helper('ccc_ftp')->__('Add Configuration');
        parent::__construct();
    }
}
