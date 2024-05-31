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

        // if ($isEdit && $model->getSecondId()) {
        //     $fieldset->addField(
        //         'second_id',
        //         'hidden',
        //         array(
        //             'name' => 'second_id',
        //         )
        //     );
        // }
        // $fieldset->addField(
        //     'middle_name',
        //     'text',
        //     array(
        //         'name'      => 'middle_name',
        //         'label'     => Mage::helper('ccc_outlook')->__('Middle Name'),
        //         'class'     => 'required-entry',
        //         'value'     => $model->getMiddleName(),
        //         'required'  => true,
        //     )
        // );
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
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
