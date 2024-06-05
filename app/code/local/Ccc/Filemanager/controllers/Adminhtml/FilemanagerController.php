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
        } else {
            Mage::getSingleton('adminhtml/session')->addError('Error occured while deleting file.');
        }
        $this->_redirect('*/*/index', ['_query' => ['isAjax' => true, 'value' => $value]]);
    }
    public function downloadAction()
    {
        $path = $this->getRequest()->getParam('path');
        $basename = $this->getRequest()->getParam('basename');
        $value = $this->getRequest()->getParam('value');
        $path = Mage::getBaseDir() . DS . $path;
        try {
            if (file_exists($path)) {
                $this->_prepareDownloadResponse($basename, array('type' => 'filename', 'value' => $path));
                Mage::getSingleton('adminhtml/session')->addSuccess('File has been downloaded.');
            }
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*/index', ['_query' => ['isAjax' => true, 'value' => $value]]);
    }
}
