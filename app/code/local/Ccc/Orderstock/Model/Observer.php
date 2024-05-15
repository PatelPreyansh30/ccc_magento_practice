<?php
class Ccc_Orderstock_Model_Observer
{
    public function insertInSalesFlatOrderAdditional(Varien_Event_Observer $observer)
    {
        $data = [];
        $order = $observer->getEvent()->getOrder();
        $data['order_id'] = $order->getId();

        foreach ($order->getAllItems() as $item) {
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            $attribute = $product->getResource()->getAttribute('brand');
            
            if($attribute){
                $brandValue = $product->getAttributeText('brand');
                $optionId = $attribute->setStoreId(0)->getSource()->getOptionId($brandValue);
                $brandCollection = Mage::getModel('orderstock/brand')->load($optionId, 'brand_id');

                $data['brand_id'] = $optionId;
                $data['mfr_id'] = $brandCollection->getMfrId();
                $data['item_id'] = $item->getId();

                $orderAdditional = Mage::getModel('orderstock/orderadditional');
                $orderAdditional->setData($data);
                $orderAdditional->save();
            }            
        }
    }
    public function sendOrderEmail(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $customerId = $order->getCustomerId();
        $customer = Mage::getModel('customer/customer')->load($customerId);

        $storeId = $order->getStoreId();
        $store = Mage::app()->getStore($storeId);

        $senderName = Mage::getStoreConfig('trans_email/ident_general/name');
        $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');

        $recipientEmail = $customer->getEmail();
        $recipientName = $customer->getName();

        $emailTemplateVariables = array(
            'order' => $order,
        );

        $emailTemplate = Mage::getModel('core/email_template')->loadDefault('sales_email_order_template');
        $emailTemplate->setSenderName($senderName);
        $emailTemplate->setSenderEmail($senderEmail);
        $emailTemplate->setTemplateSubject('Order Confirmation');
        $emailTemplate->send($recipientEmail, $recipientName, $emailTemplateVariables);
    }
}
