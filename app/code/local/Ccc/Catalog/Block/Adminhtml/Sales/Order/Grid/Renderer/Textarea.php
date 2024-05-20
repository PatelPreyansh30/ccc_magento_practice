<?php

class Ccc_Catalog_Block_Adminhtml_Sales_Order_Grid_Renderer_Textarea extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    // public function render(Varien_Object $row)
    // {
    //     $value = $row->getData($this->getColumn()->getIndex());
    //     $textareaId = $this->getColumn()->getId() . '_' . $row->getId();
    //     $textareaName = $this->getColumn()->getId() . '[' . $row->getId() . ']';
    //     $textareaHtml = '<textarea disabled onclick="toggleTextArea()" id="' . $textareaId . '" name="' . $textareaName . '" rows="4" cols="50" onfocus="focusTextarea(event)">' . $value . '</textarea>';

    //     $submitBtnHtml = '<input type="submit" value="Submit" onclick="submitTextarea(\'' . $textareaId . '\')" />';
    //     $resetBtnHtml = '<input type="reset" value="Reset" onclick="resetTextarea(\'' . $textareaId . '\')" />';

    //     $outputHtml = '<div>' . $textareaHtml . '<br />' . $submitBtnHtml . $resetBtnHtml . '</div>';

    //     return $outputHtml;
    // }
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        $value = $value ? $value : Mage::helper('sales')->__('Add new'); 
        $url = $this->getUrl('*/*/edit');
        $html = '<div toggleDiv="true" id="deliveryNote-'.$row->getId().'" onclick="toggleDeliveryNote(\'' . $row->getId() . '\',\'' . $value . '\',\'' . $url . '\')">' . $value . '</div>';
        return $html;
    }
}