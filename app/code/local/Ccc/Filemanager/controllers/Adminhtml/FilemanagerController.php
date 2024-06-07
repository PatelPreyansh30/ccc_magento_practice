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
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('ccc_filemanager/adminhtml_filemanager_grid')
                ->toHtml()
        );
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
        $this->_redirect('*/*/index', ['_query' => ['isAjax' => true, 'value' => base64_encode($value)]]);
    }
    public function downloadAction()
    {
        $path = Mage::getBaseDir() . DS . ($this->getRequest()->getParam('path'));
        $basename = $this->getRequest()->getParam('basename');
        if (file_exists($path)) {
            $this->_prepareDownloadResponse($basename, array('type' => 'filename', 'value' => $path));
        }
    }
    public function renameAction()
    {
        try {
            $newFilename = $this->getRequest()->getParam('new_filename');
            $oldFilename = $this->getRequest()->getParam('old_filename');
            $fullpath = $this->getRequest()->getParam('fullpath');
            $newPath = str_replace($oldFilename, $newFilename, $fullpath);

            if (file_exists($fullpath) && !file_exists($newPath)) {
                rename($fullpath, $newPath);
                $response = ['success' => true, 'message' => "Rename completed successfully."];
            } else {
                throw new Exception("File name already exists.");
            }
        } catch (Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }
}
