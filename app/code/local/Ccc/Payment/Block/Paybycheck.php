<?php

class Ccc_Payment_Block_Paybycheck extends Mage_Adminhtml_Block_Sales_Order_View_Info
{
    public function getPoNumber(){
        return $this->getOrder()->getPayment()->getPoNumber();
    }
}