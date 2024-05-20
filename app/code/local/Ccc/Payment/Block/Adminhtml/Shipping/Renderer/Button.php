<?php

class Ccc_Payment_Block_Adminhtml_Shipping_Renderer_Button extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $methodCode = $row->getData('method_amount');
        $url = $this->getUrl('*/payment/shippingmethod');
        $html = '<button type="button" onclick="shippingmethodGridJsObject.showModal(\'' . $methodCode . '\',\'' . $url . '\')">Update</button>';
        return $html;
    }
}
