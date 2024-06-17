<?php

class Ccc_Ticket_Adminhtml_TicketController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('ticket');
        return $this;
    }
    public function indexAction()
    {
        $this->_initAction();
        $this->_title($this->__("Ticket"));
        $this->renderLayout();
    }
    public function viewAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }
    public function saveAction()
    {
        $data = $this->getRequest()->getParams();
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
    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        $data = $this->getRequest()->getParams();
        try {
            Mage::getModel('ccc_ticket/ticket')->load($id)
                ->addData($data)
                ->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('ccc_ticket')->__('Ticket has been updated.')
            );
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('ccc_ticket')->__('Error occured while updating ticket.')
            );
        }
        $this->_redirect('*/*/view', ['id' => $id]);
    }
}
