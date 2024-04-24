<?php
class Ccc_Orderstatus_Model_Resource_Orderstatus extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('orderstatus/orderstatus', 'entity_id');
    }
}
