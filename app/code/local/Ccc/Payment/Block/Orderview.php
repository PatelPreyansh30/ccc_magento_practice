<?php

class Ccc_Payment_Block_Orderview extends Mage_Adminhtml_Block_Sales_Order_View_Info
{
    public function getPaymentId()
    {
        return $this->getOrder()->getPayment()->getPoNumber();
    }
}