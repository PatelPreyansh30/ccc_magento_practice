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
    public function downloadAction()
    {
        $path = Mage::helper('ccc_ftp')->getLocalDir() . DS . ($this->getRequest()->getParam('path'));
        if (file_exists($path)) {
            $this->_prepareDownloadResponse(basename($path), array('type' => 'filename', 'value' => $path));
        }
    }
    public function extractAction()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $file = Mage::getModel('ccc_ftp/files')->load($id);
            if ($file->getFileName()) {
                $localPath = Mage::helper('ccc_ftp')->getLocalDir();
                $folderName = explode('.', $file->getFileName())[0];
                $zipPath = $file->getFileName();
                if ($file->getPath()) {
                    $zipPath = substr($file->getPath(), 1) . DS . $file->getFileName();
                    $folderName = substr($file->getPath(), 1) . DS . $folderName;
                }
                $zipPath = $localPath . DS . $zipPath;
                $folderName = $localPath . DS . $folderName;
                if (!file_exists($folderName)) {
                    mkdir($folderName, 0777);
                }

                $zipModel = new Zend_Filter_Compress_Zip();
                $zipModel->setTarget($folderName);
                $zipModel->decompress($zipPath);

                $files = $this->recursiveLs($folderName);
                if (!empty($files)) {
                    $status = $this->transferFiles($files, $file);
                    if ($status) {
                        $file->delete();
                        unlink($zipPath);
                        Mage::getSingleton('adminhtml/session')->addSuccess(
                            Mage::helper('ccc_ftp')->__('The Zip file has been extracted.')
                        );
                    }
                }
            }
        }
        $this->_redirect('*/*/index');
    }
    protected function recursiveLs($dir, &$results = [])
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DS . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                $this->recursiveLs($path, $results);
            }
        }

        return $results;
    }
    protected function transferFiles($files, $fileModel)
    {
        try {
            $configModel = Mage::getModel('ccc_ftp/configuration')->load($fileModel->getConfigId());
            foreach ($files as $file) {
                $localPath = Mage::helper('ccc_ftp')->getLocalDir();
                $file = str_replace($localPath, '', $file);

                $fileData = [
                    'newname' => basename($file),
                    'path' => stristr($file, DS . basename($file), true),
                    'date' => filemtime($localPath . $file),
                ];

                Mage::getModel('ccc_ftp/files')
                    ->setConfigModel($configModel)
                    ->setRawData($fileData)
                    ->save();
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function convertAction()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $localPath = Mage::helper('ccc_ftp')->getLocalDir();
            $fileModel = Mage::getModel('ccc_ftp/files')->load($id);
            $config = new Varien_Simplexml_Config();
            $config->loadFile($localPath . $fileModel->getPath() . DS . $fileModel->getFileName());

            $mapping = Mage::helper('ccc_ftp')->xmlMapping();

            $csv = [];
            foreach ($config->getNode('items')->children() as $item) {
                $data = [];
                foreach ($mapping as $key => $map) {
                    $map = explode(':', $map);
                    $path = str_replace('.', '/', $map[0]);
                    $attribute = $map[1];

                    if ($item->descend($path)) {
                        $value = (string) $item->descend($path)->attributes()->$attribute;
                        $data[$key] = $value;
                    }
                }
                $csv[] = $data;
            }
            if (!empty($csv)) {
                $csvFileName = $localPath . $fileModel->getPath() . DS . $fileModel->getFileName();
                $csvFileName = explode('.', $csvFileName)[0] . '.csv';
                $cs = fopen($csvFileName, 'w');
                fputcsv($cs, array_keys($mapping), ',');

                foreach ($csv as $_csv) {
                    fputcsv($cs, $_csv, ',');
                }
                fclose($cs);
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('ccc_ftp')->__('The XML file has been converted into CSV.')
                );
            }
        }
        $this->_redirect('*/*/index');
    }
}
