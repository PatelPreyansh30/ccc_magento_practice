<?php

class Ccc_Ftp_Adminhtml_Ftp_FileController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('ftp');
        return $this;
    }
    public function indexAction()
    {
        $this->_initAction();
        $this->_title($this->__("FTP File"));
        $this->renderLayout();
    }
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('ccc_ftp/adminhtml_file_grid')
                ->toHtml()
        );
    }
}
