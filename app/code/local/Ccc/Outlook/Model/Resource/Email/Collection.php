<?php

class Ccc_Outlook_Model_Resource_Email_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('outlook/email');
    }
}