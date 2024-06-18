<?php

class Ccc_Ticket_Adminhtml_Ticket_FilterController extends Mage_Adminhtml_Controller_Action
{
    public function saveAction()
    {
        $data = $this->getRequest()->getParam('data');
        print_r($data);
        die;

        try {
            Mage::getModel('ccc_ticket/ticket')->setData($data)->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('ccc_ticket')->__('Ticket has been created.')
            );
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('ccc_ticket')->__('Error occured while creating ticket.')
            );
        }
        $this->_redirectUrl($this->_getRefererUrl());
    }
    
}
