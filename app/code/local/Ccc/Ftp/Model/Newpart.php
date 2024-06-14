<?php
class Ccc_Ftp_Model_Newpart extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('ccc_ftp/newpart');
    }
    public function setRawData()
    {
        $this->setData($this->getMasterModel()->getData());
        $this->setNewPartDate(date('Y-m-d H:i:s'));
        return $this;
    }
}
