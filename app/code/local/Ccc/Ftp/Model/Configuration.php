<?php
class Ccc_Ftp_Model_Configuration extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('ccc_ftp/configuration');
    }
    public function fetchFiles()
    {
        $files = Mage::getModel('ccc_ftp/ftp')
            ->setConfigModel($this)
            ->fetchAndMoveFile();

        if (!empty($files)) {
            foreach ($files as $file) {
                Mage::getModel('ccc_ftp/files')
                    ->setConfigModel($this)
                    ->setRawData($file)
                    ->save();
            }
        }
    }
}