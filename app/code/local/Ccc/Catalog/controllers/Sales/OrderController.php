<?php
require_once Mage::getModuleDir('controllers', 'Mage_Adminhtml') . '/Sales/OrderController.php';

class Ccc_Catalog_Sales_OrderController extends Mage_Adminhtml_Sales_OrderController
{
    public function editAction()
    {
        $entityId = $this->getRequest()->getPost('id');
        $newDeliveryNote = $this->getRequest()->getPost('value');

        $order = Mage::getModel('sales/order')->load($entityId);
        if ($order->getId()) {
            $order->setData('delivery_note', $newDeliveryNote);
            $order->save();
        }
        $this->_redirect('*/*/index');
    }
    public function validateAddressAction()
    {
        $orderId = $this->getRequest()->getParam('order_id');
        $orderModel = Mage::getModel('sales/order')->load($orderId);
        $orderModel->setData('address_validation_required', 2);
        $orderModel->save();

        Mage::getSingleton('adminhtml/session')
            ->addSuccess('Address validate successfully');
    }
    public function emailvalidationAction()
    {
        $orderIds = $this->getRequest()->getPost('order_ids', array());
        foreach ($orderIds as $orderId) {
            $order = Mage::getModel('sales/order')->load($orderId);
            if ($order->getAddressValidationRequired() == 1 && $order->getStatus() != 'complete' && $order->getStatus() != 'canceled') {
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
            }
        }
        $this->_getSession()->addSuccess($this->__('All Email Send Successful'));
        $this->_redirect('*/*/');
    }
}