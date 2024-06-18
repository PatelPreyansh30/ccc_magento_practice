<?php

class Ccc_Ticket_Block_Adminhtml_View_Comment extends Mage_Adminhtml_Block_Template
{
    public function getComments()
    {
        return Mage::getModel('ccc_ticket/comment')
        ->getCollection()
            ->addFieldToFilter('ticket_id', $this->getRequest()->getParam('id'));
    }
}
