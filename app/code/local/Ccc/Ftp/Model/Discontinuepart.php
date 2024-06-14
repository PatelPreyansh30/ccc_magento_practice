<?php
class Ccc_Ftp_Model_Discontinuepart extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('ccc_ftp/discontinuepart');
    }

    public function setRawData()
    {
        $this->setData($this->getMasterModel()->getData());
        $this->setDiscontinuePartDate(date('Y-m-d H:i:s'));
        return $this;
    }
}
