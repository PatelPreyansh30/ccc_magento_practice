<?php

class Ccc_Payment_Block_Adminhtml_Shipping_Renderer_Button extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $methodCode = $row->getData('method_code');
        $amount = $row->getData('method_amount');
        $url = $this->getUrl('adminhtml/system_config/save') . 'section/carriers/';
        $ranges = explode(',', $amount);
        $result = array();
        foreach ($ranges as $index => $range) {
            if (preg_match('/(\d+)\s*-\s*(\d*)\s*=\s*([\d.]+)/', trim($range), $matches)) {
                $from = (int) $matches[1];
                $to = $matches[2] !== '' ? (int) $matches[2] : null;
                $price = (float) $matches[3];
                $result[] = array(
                    'from' => $from,
                    'to' => $to,
                    'price' => $price
                );
            }
        }
        $jsonResult = json_encode($result);
        $url = $this->getUrl('adminhtml/system_config/save') . 'section/carriers/';
        $js = <<<JS
<script type="text/javascript">
document.observe("dom:loaded", function() {
        var editDataInstance = new editData('{$methodCode}',JSON.parse('{$jsonResult}'),'{$url}');
    });
</script>
JS;
        $html = $js . '<button type="button" id="amount-' . $methodCode . '">Update</button>';
        return $html;
    }
}
