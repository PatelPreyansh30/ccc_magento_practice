<?php

class Ccc_Catalog_Block_Adminhtml_Sales_Order_View_Deliverynote extends Mage_Adminhtml_Block_Sales_Order_View_Info
{
    public function getDeliveryNoteEditLink($order, $label = '')
    {
        if (empty($label)) {
            $label = $this->__('Edit');
        }
        $url = $this->getUrl('*/sales_order/edit', array('order_id' => $order->getId()));
        return '<a href="' . $url . '">' . $label . '</a>';
    }
}