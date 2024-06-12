<?php
class Ccc_Ftp_Model_Resource_Files extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('ccc_ftp/files', 'file_id');
    }
}
