<?php

class Ccc_Filemanager_Adminhtml_FilemanagerController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('filemanager');
        return $this;
    }
    public function indexAction()
    {
        $this->_initAction();
        $this->_title($this->__("Filemanager"));
        $this->renderLayout();
    }
}
