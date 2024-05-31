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
            'client_id',
            'text',
            array(
                'name' => 'client_id',
                'label' => Mage::helper('ccc_outlook')->__('Client Id'),
                'class' => 'required-entry',
                'required' => true,
            )
        );
        $fieldset->addField(
            'client_secret',
            'text',
            array(
                'name' => 'client_secret',
                'label' => Mage::helper('ccc_outlook')->__('Client Secret'),
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
        if ($isEdit && $model->getClientId()) {
            $fieldset->addField(
                'login_btn',
                'note',
                array(
                    'client_id' => $model->getClientId(),
                    'entity_id' => $model->getId(),
                )
            )->setRenderer($this
                    ->getLayout()
                    ->createBlock('ccc_outlook/adminhtml_configuration_renderer_link'));
        }
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