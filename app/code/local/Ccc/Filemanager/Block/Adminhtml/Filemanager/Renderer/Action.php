<?php
class Ccc_Filemanager_Block_Adminhtml_Filemanager_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $path = $row->getData('fullpath');
        $value = $row->getData('main_directory');
        $deleteurl = $this->getUrl('*/filemanager/delete');
        $downloadurl = $this->getUrl('*/filemanager/download');

        $html = '<a href="' . $downloadurl . '?path=' . $path . '&value=' . $value . '" target="_blank" type="button">Download</a>';
        $html .= "<br>";
        $html .= '<a href="' . $deleteurl . '?path=' . $path . '&value=' . $value . '"  type="button">Delete</a>';

        return $html;
    }
}

