<?php

class Ccc_Ticket_Block_Adminhtml_View_Details extends Ccc_Ticket_Block_Adminhtml_Abstract
{
    public function getTicket()
    {
        return $this->getTickets($this->getRequest()->getParam('id'));
    }
}
