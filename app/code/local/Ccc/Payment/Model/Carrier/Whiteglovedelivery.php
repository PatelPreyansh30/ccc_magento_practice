<?php

class Ccc_Payment_Model_Carrier_Whiteglovedelivery extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface
{
    protected $_code = 'whiteglovedelivery';

    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $result = Mage::getModel('shipping/rate_result');

        $method = Mage::getModel('shipping/rate_result_method');

        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));
        $total = $request->getPackageValue();
        $amount = $this->getConfigData('amount');
        $methods = unserialize($amount);
        foreach ($methods as $_amount) {
            if ($_amount['to'] != null) {
                if ($total >= $_amount['from'] && $total <= $_amount['to']) {
                    $method->setData('price', $_amount['price']);
                    break;
                }
            } else {
                $method->setData('price', $_amount['price']);
                break;
            }
        }
        $result->append($method);
        return $result;
    }

    public function getAllowedMethods()
    {
        return array($this->_code => $this->getConfigData('name'));
    }
}
