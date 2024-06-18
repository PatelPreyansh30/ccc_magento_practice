<?php
class Ccc_Ticket_Block_Adminhtml_Filter extends Mage_Adminhtml_Block_Template
{
    public function getUsers()
    {
        return Mage::getModel('admin/user')->getCollection();
    }
    public function getStatus()
    {
        return Mage::getModel('ccc_ticket/status')->getCollection();
    }
}
