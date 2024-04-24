<?php

class Ccc_Orderstatus_Adminhtml_OrderstatusController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('system');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__("Orderstatus"));
        $this->_initAction();
        $this->renderLayout();
    }
}