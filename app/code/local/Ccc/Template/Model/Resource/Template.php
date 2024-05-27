<?php
class Ccc_Template_Model_Resource_Template extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('ccc_template/exception_template', 'entity_id');
    }
}
