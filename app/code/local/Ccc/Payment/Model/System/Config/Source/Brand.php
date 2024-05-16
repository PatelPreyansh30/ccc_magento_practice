<?php
class Ccc_Payment_Model_System_Config_Source_Brand
{
    public function toOptionArray()
    {
        $brandoptions = [];
        $attributeCode = 'brand';
        $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);
        $options = $attribute->getSource()->getAllOptions();
        foreach ($options as $option) {
            if ($option['value'] == '')
            continue;
            $brandoptions[] = array(
                'value' => $option['value'],
                'label' => $option['label'],
            );
        }
        return $brandoptions;
    }
}
