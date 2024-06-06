<?php
class Ccc_Filemanager_Block_Adminhtml_Filemanager_Renderer_Input extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $renameUrl = $this->getUrl('*/*/rename');
        $data = json_encode($row->getData());
        $html = "<div class='' url='" . $renameUrl . "' data='" . $data . "' onclick='inlineChange(this)'>" . $row->getFilename() . '</div>';
        return $html;
    }
}
