<?php
class Ccc_Ftp_Block_Adminhtml_Xml extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_xml';
        $this->_blockGroup = 'ccc_ftp';
        $this->_headerText = Mage::helper('ccc_ftp')->__('XML Parts');
        parent::__construct();
        $this->_removeButton('add');
    }
}
