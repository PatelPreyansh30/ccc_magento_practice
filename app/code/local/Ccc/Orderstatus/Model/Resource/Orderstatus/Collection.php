<?php

class Ccc_Orderstatus_Model_Resource_Orderstatus_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct(){
        parent::_construct();
        $this->_init('orderstatus/orderstatus');
    }
}