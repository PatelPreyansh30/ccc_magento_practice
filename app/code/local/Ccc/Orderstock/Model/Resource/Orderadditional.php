<?php

class Ccc_Orderstock_Model_Resource_Orderadditional extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('orderstock/orderadditional', 'entity_id');
    }
}