<?php
class Ccc_Ticket_Block_Adminhtml_View extends Ccc_Ticket_Block_Adminhtml_Abstract
{
    protected $_ticketDetails;

    public function __construct()
    {
    }
    public function getTicket()
    {
        return $this->getTickets($this->getRequest()->getParam('id'));
    }
    public function getComments()
    {
        return Mage::getModel('ccc_ticket/comment')
            ->getCollection()
            ->addFieldToFilter('ticket_id', $this->getRequest()->getParam('id'));
    }
    public function getUsers()
    {
        return Mage::getModel('admin/user')->getCollection();
    }
    public function getStatus()
    {
        return Mage::getModel('ccc_ticket/status')->getCollection();
    }
}
