<?php
class Ccc_Catalog_Block_Adminhtml_Renderer_Validation extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());

        if ($value == 0 || $row->getStatus() == 'canceled' || $row->getStatus() == 'complete') {
            return Mage::helper('sales')->__("N/A");
        } elseif ($value == '1') {
            $orderId = $row->getId();
            $url = $this->getUrl('*/sales_order/validateAddress', array('order_id' => $orderId));
            return '<button type="button" class="scalable" onclick="addressValidate(' . $orderId . ',\'' . $url . '\')">Validate</button>';
        } else {
            return Mage::helper('sales')->__("Validated");
        }
    }
}