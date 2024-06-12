<?php
class Ccc_Ftp_Model_Files extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('ccc_ftp/files');
    }
    public function setRawData($file)
    {
        $this->setConfigId($this->getConfigModel()->getId());
        $this->setFileName($file['newname']);
        $this->setPath($file['path']);
        $this->setRecievedDate(date('Y-m-d H:i:s', $file['date']));

        return $this;
    }
}