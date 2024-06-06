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
        $path = Mage::getBaseDir() . DS . $path;
        $basename = $this->getRequest()->getParam('basename');
        $value = $this->getRequest()->getParam('value');
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
    public function renameAction()
    {
        $newFilename = $this->getRequest()->getParam('new_filename');
        $oldFilename = $this->getRequest()->getParam('old_filename');
        $fullpath = $this->getRequest()->getParam('fullpath');

        try {
            $pathArray = explode("\\", $fullpath);
            $newPath = str_replace($oldFilename, $newFilename, array_slice($pathArray, -1)[0]);

            array_pop($pathArray);
            $pathArray[] = $newPath;
            $newPath = implode("\\", $pathArray);

            if (file_exists($fullpath)) {
                rename($fullpath, $newPath);
            }

            $response = ['success' => true, 'message' => "Rename completed successfully."];
        } catch (Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }
}
