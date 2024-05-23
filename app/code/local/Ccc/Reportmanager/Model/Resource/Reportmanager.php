<?php
class Ccc_Reportmanager_Model_Resource_Reportmanager extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('reportmanager/reportmanager', 'id');
    }
}
