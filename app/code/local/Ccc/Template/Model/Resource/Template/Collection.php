<?php

class Ccc_Template_Model_Resource_Template_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('ccc_template/template');
    }
}