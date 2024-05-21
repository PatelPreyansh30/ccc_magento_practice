<?php

class Ccc_Orderstock_Block_Adminhtml_Orderstock_Grid_Renderer_EditButton extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $entityId = $row->getData('entity_id');
        $field = [0 => 'manufacturer_name', 1 => 'email'];
        $field = json_encode($field);
        $editUrl = $this->getUrl('*/*/rowEdit', array('entity_id' => $entityId));
        $output = "<a href='#' 
        class='edit-row' 
        data-url='{$editUrl}' 
        data-entity-id='{$entityId}'
        data-field='{$field}'>Edit</a>";
        return $output;
    }
}
