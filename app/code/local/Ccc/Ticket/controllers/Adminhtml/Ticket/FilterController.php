<?php

class Ccc_Ticket_Adminhtml_Ticket_FilterController extends Mage_Adminhtml_Controller_Action
{
    public function saveAction()
    {
        $data = json_decode($this->getRequest()->getParam('data'), true);
        $name = $data['name'];
        unset($data['name']);
        $data = json_encode($data);
        try {
            $currentUserId = Mage::getSingleton('admin/session')->getUser()->getId();
            Mage::getModel('ccc_ticket/filter')
                ->setName($name)
                ->setUserId($currentUserId)
                ->setJsonData($data)
                ->save();
        } catch (Exception $e) {
        }
    }
}
