<?php

class Ccc_Validation_Adminhtml_ValidationController extends Mage_Adminhtml_Controller_Action
{
    public function validationAction()
    {
        $orderId =  $this->getRequest()->getParam('increment_id');
        $order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
        $order->setData('address_validation_required',0);
        $order->save();
    }
}
