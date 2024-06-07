<?php
class Ccc_Filemanager_Block_Adminhtml_Filemanager_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $path = $row->getData('fullpath');
        $basePath = $row->getData('basename');
        $value = $row->getData('main_directory');
        $deleteurl = $this->getUrl('*/filemanager/delete');
        $downloadurl = $this->getUrl('*/filemanager/download');

        $html = '<a id="download-' . $row->getId() . '" href="' . $downloadurl . '?path=' . $path . '&basename=' . $basePath . '" target="_blank" type="button">Download</a>';
        $html .= "<br>";
        $html .= '<a id="delete-' . $row->getId() . '" href="' . $deleteurl . '?path=' . $path . '&value=' . $value . '"  type="button">Delete</a>';

        return $html;
    }
}

