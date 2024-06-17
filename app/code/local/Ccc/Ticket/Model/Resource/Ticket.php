<?php
class Ccc_Ticket_Model_Resource_Ticket extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('ccc_ticket/ticket', 'ticket_id');
    }
}
