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
    public function deleteAction()
    {
        $path = $this->getRequest()->getParam('path');
        $value = $this->getRequest()->getParam('value');
        if (file_exists($path)) {
            unlink($path);
            Mage::getSingleton('adminhtml/session')->addSuccess('File has been deleted.');
        }
        Mage::getSingleton('adminhtml/session')->addError('Error occured while deleting file.');
        $this->_redirect('*/*/index', ['_query' => ['isAjax' => true, 'value' => $value]]);
    }
    public function downloadAction()
    {
        $path = $this->getRequest()->getParam('path');
        $value = $this->getRequest()->getParam('value');
        if (file_exists($path)) {

            Mage::getSingleton('adminhtml/session')->addSuccess('File has been downloaded.');
        }
        Mage::getSingleton('adminhtml/session')->addError('Error occured while downloaded file.');
        $this->_redirect('*/*/index', ['_query' => ['isAjax' => true, 'value' => $value]]);
    }
}
