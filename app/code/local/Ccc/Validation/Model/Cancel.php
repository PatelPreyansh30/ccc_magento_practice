<?php
class Ccc_Validation_Model_Cancel extends Mage_Sales_Model_Order
{
    public function cancel()
    {
        if ($this->canCancel()) {
            $this->getPayment()->cancel();
            $this->registerCancellation();
            Mage::dispatchEvent('custom_order_cancel_email', array('order' => $this));
        }
        return $this;
    }
}