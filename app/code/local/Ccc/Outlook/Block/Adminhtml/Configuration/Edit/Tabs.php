<?php
class Ccc_Outlook_Block_Adminhtml_Configuration_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('page_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('ccc_outlook')->__('Configuration'));
    }
}
