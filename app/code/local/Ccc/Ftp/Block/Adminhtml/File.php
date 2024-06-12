<?php
class Ccc_Ftp_Block_Adminhtml_File extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_file';
        $this->_blockGroup = 'ccc_ftp';
        $this->_headerText = Mage::helper('ccc_ftp')->__('FTP Files');
        parent::__construct();
        $this->_removeButton('add');
    }
}
