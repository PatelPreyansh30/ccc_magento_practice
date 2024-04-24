<?php
class Ccc_Orderstatus_Block_Adminhtml_Orderstatus_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('orderstatus_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('orderstatus')->__('Order Status Information'));
    }
}
