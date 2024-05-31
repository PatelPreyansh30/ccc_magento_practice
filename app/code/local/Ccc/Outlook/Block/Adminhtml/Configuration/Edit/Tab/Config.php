<?php
class Ccc_Outlook_Block_Adminhtml_Configuration_Edit_Tab_Config extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        $model = Mage::registry('ccc_outlook');
        $isEdit = ($model && $model->getId());
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('ccc_outlook')->__('General Information'), 'class' => 'fieldset-wide'));

        if ($isEdit && $model->getEntityId()) {
            $fieldset->addField(
                'entity_id',
                'hidden',
                array(
                    'name' => 'entity_id',
                )
            );
        }
        $fieldset->addField(
            'user_name',
            'text',
            array(
                'name' => 'user_name',
                'label' => Mage::helper('ccc_outlook')->__('User Name'),
                'class' => 'required-entry',
                'required' => true,
            )
        );
        $fieldset->addField(
            'password',
            'text',
            array(
                'name' => 'password',
                'label' => Mage::helper('ccc_outlook')->__('Password'),
                'class' => 'required-entry',
                'required' => true,
            )
        );
        $fieldset->addField(
            'api_url',
            'text',
            array(
                'name' => 'api_url',
                'label' => Mage::helper('ccc_outlook')->__('Api URL'),
                'class' => 'required-entry',
                'required' => true,
            )
        );
        $fieldset->addField(
            'api_key',
            'text',
            array(
                'name' => 'api_key',
                'label' => Mage::helper('ccc_outlook')->__('Api Key'),
                'class' => 'required-entry',
                'required' => true,
            )
        );
        $fieldset->addField(
            'is_active',
            'select',
            array(
                'name' => 'is_active',
                'label' => Mage::helper('ccc_outlook')->__('Is Active'),
                'class' => 'required-entry',
                'required' => true,
                'options' => array(
                        '1' => Mage::helper('ccc_outlook')->__('Enable'),
                        '0' => Mage::helper('ccc_outlook')->__('Disable'),
                    )
            )
        );
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
    public function getTabLabel()
    {
        return Mage::helper('ccc_outlook')->__('Configuration information');
    }
    public function getTabTitle()
    {
        return Mage::helper('ccc_outlook')->__('Configuration information');
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