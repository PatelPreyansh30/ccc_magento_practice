<?php
require_once Mage::getModuleDir('controllers', 'Mage_Adminhtml') . '/Sales/OrderController.php';

class Ccc_Catalog_Sales_OrderController extends Mage_Adminhtml_Sales_OrderController
{
    public function editAction()
    {
        $responce = [];
        $entityId = $this->getRequest()->getPost('entity_id');
        $newDeliveryNote = $this->getRequest()->getPost('delivery_note');

        try {
            $order = Mage::getModel('sales/order')->load($entityId);
            if ($order->getId()) {
                $order->setData('delivery_note', $newDeliveryNote);
                $order->save();
                $responce['success'] = true;
                $responce['message'] = 'Delivery note updated successfully';
            } else {
                $responce['success'] = false;
                $responce['message'] = 'Order does not exist';
            }
        } catch (Exception $e) {
            $responce['success'] = false;
            $responce['message'] = $e->getMessage();
        }
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($responce));
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
}