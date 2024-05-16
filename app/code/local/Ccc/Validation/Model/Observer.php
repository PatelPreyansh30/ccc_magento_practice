<?php
class Ccc_Validation_Model_Observer
{
    public function triggerAddressValidationEmail($observer)
    {
        Mage::log('hello',null,'xyz.log',true);
        $order = $observer->getEvent()->getOrder();
        if (
            $order->getBillingAddress()->getData('street') !== $order->getShippingAddress()->getData('street') ||
            $order->getBillingAddress()->getData('city') !== $order->getShippingAddress()->getData('city') ||
            $order->getBillingAddress()->getData('postcode') !== $order->getShippingAddress()->getData('postcode')
        ) {
            $order->setAddressValidationRequired(1);
            $order->setValidationEmailSentCount(1);
        } else {
            $order->setAddressValidationRequired(2);
        }
        $order->save();
        if ($order->getAddressValidationRequired() == 1) {
            $customerId = $order->getCustomerId();
            $customer = Mage::getModel('customer/customer')->load($customerId);
            
            $senderName = Mage::getStoreConfig('trans_email/ident_general/name');
            $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');

            $recipientEmail = $customer->getEmail();
            $recipientName = $customer->getName();

            $emailTemplateVariables = array(
                'name' => $recipientName,
                'ordernum' => $order->getIncrementId(),
            );
            $emailTemplate = Mage::getModel('core/email_template')->load('address_validation', 'template_code');
            $emailTemplate->setSenderName($senderName);
            $emailTemplate->setSenderEmail($senderEmail);
            $emailTemplate->setTemplateSubject('Address Validation Email');
            $emailTemplate->send($recipientEmail, $recipientName, $emailTemplateVariables);
        }
    }
    public function  triggerCancelEmail($observer){
        $order = $observer->getEvent()->getOrder();
        $orderItem = Mage::getModel('sales/order_item')->getCollection()->addFieldToFilter('order_id',$order->getId());
        $item = [];
        foreach($orderItem as $orderData){
            $item[] = $orderData->getName().' <br> qty:'.$orderData->getQtyOrdered();
        }
        $item = implode('<br>',$item);

        $customerId = $order->getCustomerId();
        $customer = Mage::getModel('customer/customer')->load($customerId);
        
        $senderName = Mage::getStoreConfig('trans_email/ident_general/name');
        $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');

        $recipientEmail = $customer->getEmail();
        $recipientName = $customer->getName();

        $emailTemplateVariables = array(
            'orderid' => $order->getIncrementId(),
            'customername' => $recipientName,
            'orderamount' => $order->getBaseSubtotal(),
            'item' => $item
        );
        Mage::log($emailTemplateVariables,null,'vivek1.log',true);
        $emailTemplate = Mage::getModel('core/email_template')->load('cancel_order', 'template_code');
        $emailTemplate->setSenderName($senderName);
        $emailTemplate->setSenderEmail($senderEmail);
        $emailTemplate->send($recipientEmail, $recipientName, $emailTemplateVariables);
    }
    public function allAddressValidation(){
        $orders = Mage::getModel('sales/order')
        ->getCollection()
        ->addFieldToFilter('address_validation_required',1)
        ->addFieldToFilter('status',array('neq'=>'canceled'))
        ->addFieldToFilter('status',array('neq'=>'complete'));

        foreach($orders as $order){
            if($order->getValidationEmailSentCount() < 3){
            $customerId = $order->getCustomerId();
            $customer = Mage::getModel('customer/customer')->load($customerId);
            $senderName = Mage::getStoreConfig('trans_email/ident_general/name');
            $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');
            $recipientEmail = $customer->getEmail();
            $recipientName = $customer->getName();
            $emailTemplateVariables = array(
                'name' => $recipientName,
                'ordernum' => $order->getIncrementId(),
            );
            $emailTemplate = Mage::getModel('core/email_template')->load('address_validation', 'template_code');
            $emailTemplate->setSenderName($senderName);
            $emailTemplate->setSenderEmail($senderEmail);
            $emailTemplate->setTemplateSubject('Address Validation Email');
            $emailTemplate->send($recipientEmail, $recipientName, $emailTemplateVariables);
            $order->setValidationEmailSentCount($order->getValidationEmailSentCount() + 1);
            $order->save();
        }else{
            $order->setData('status','canceled');
            $order->save();
        }
        }
    }
}
