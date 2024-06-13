<?php
class Ccc_Ftp_Block_Adminhtml_File_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $id = $row->getData('file_id');
        $path = $row->getData('path') . DS . $row->getData('file_name');
        $extractUrl = $this->getUrl('*/ftp_file/extract');
        $convertUrl = $this->getUrl('*/ftp_file/convert');
        $downloadUrl = $this->getUrl('*/ftp_file/download');
        $html = '<a href="' . $downloadUrl . '?path=' . $path . '" class="button">Download</a>';
        if (stripos($path, '.zip')) {
            $html .= ' || <a href="' . $extractUrl . '?id=' . $id . '" class="button">Extract</a>';
        } elseif (stripos($path, '.xml')) {
            $html .= ' || <a href="' . $convertUrl . '?id=' . $id . '" class="button">Convert</a>';
        }
        return $html;
    }
}

