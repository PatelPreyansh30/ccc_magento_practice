<?php

class Ccc_Orderstock_Model_Resource_Orderadditional_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('orderstock/orderadditional');
    }
}