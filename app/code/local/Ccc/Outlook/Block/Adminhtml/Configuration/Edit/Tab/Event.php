<?php
class Ccc_Outlook_Block_Adminhtml_Configuration_Edit_Tab_Event extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        $model = Mage::registry('ccc_outlook');
        $isEdit = ($model && $model->getId());

        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('block_');
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('ccc_outlook')->__('Event Information'), 'class' => 'fieldset-wide'));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
    public function getEventsData()
    {
        return Mage::registry('event_data');
    }
    public function getTabLabel()
    {
        return Mage::helper('ccc_outlook')->__('Events');
    }
    public function getTabTitle()
    {
        return Mage::helper('ccc_outlook')->__('Events');
    }
    public function canShowTab()
    {
        return true;
    }
    public function isHidden()
    {
        return false;
    }
}
