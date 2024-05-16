<?php

class Ccc_Payment_Model_Method_Paybycheck extends Mage_Payment_Model_Method_Abstract
{
    protected $_code  = 'paybycheck';
    // protected $_formBlockType = 'ccc_payment/form_paybycheck';
    // public function assignData($data)
    // {
    //     if (!($data instanceof Varien_Object)) {
    //         $data = new Varien_Object($data);
    //     }
    //     $this->getInfoInstance()->setPoNumber($data->getPoNumber());
    //     return $this;
    // }
}
