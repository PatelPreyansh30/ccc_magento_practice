<?php
class Ccc_Payment_Block_Form_Paybycheck extends Mage_Payment_Block_Form {
    protected function _construct(){
        parent::_construct();
        $this->setTemplate('ccc/catalog/checkout/payment/paybycheck.phtml');
    }
}