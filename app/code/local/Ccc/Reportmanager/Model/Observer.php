<?php

class Ccc_Reportmanager_Model_Observer
{
    public function addSoldCount(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();

        foreach ($order->getAllItems() as $item) {
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            $soldCount = 0;
            $attribute = (int) $product->getSoldCount();
            $qty = (int) $item->getQtyOrdered();
            if ($qty != 0) {
                $soldCount = $attribute + $qty;
            } else {
                $soldCount = (int) $qty;
            }
            $product->setSoldCount($soldCount)->save();
        }
    }
    public function minusSoldCount(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();

        foreach ($order->getAllItems() as $item) {
            $product = Mage::getModel('catalog/product')->load($item->getProductId());
            $attribute = (int) $product->getSoldCount();
            $qty = (int) $item->getQtyOrdered();
            if ($attribute != 0) {
                $soldCount = $attribute - $qty;
                $product->setSoldCount($soldCount)->save();
                Mage::log($soldCount, null, 'cancel.log', true);
                Mage::log($attribute, null, 'cancel2.log', true);
            }
            Mage::log($item->getQtyOrdered(), null, 'cancel3.log', true);
        }
    }
}