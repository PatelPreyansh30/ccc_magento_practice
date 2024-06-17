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
    public function getCommentDetail()
    {
        return $this->_ticketDetails['comment'];
    }
}
