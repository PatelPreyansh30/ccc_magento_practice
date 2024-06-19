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
    public function getFilters()
    {
        $currentUserId = Mage::getSingleton('admin/session')
            ->getUser()
            ->getId();
        return Mage::getModel('ccc_ticket/filter')
            ->getCollection()
            ->addFieldToFilter('user_id', $currentUserId);
    }
}
