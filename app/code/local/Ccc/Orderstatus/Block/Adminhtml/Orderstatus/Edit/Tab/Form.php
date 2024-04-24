<?php

class Ccc_Orderstatus_Block_Adminhtml_Orderstatus_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        $model = Mage::registry('orderstatus');

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('orderstatus_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            array(
                'legend' => Mage::helper('orderstatus')->__('General Information'),
                'class' => 'fieldset-wide'
            )
        );

        if ($model->getId()) {
            $fieldset->addField(
                'entity_id',
                'hidden',
                array(
                    'name' => 'entity_id',
                )
            );
        }

        $statuses = Mage::getResourceModel('sales/order_status_collection')->toOptionArray();
        array_unshift($statuses, array('value' => '', 'label' => ''));

        $fieldset->addField(
            'status',
            'select',
            array(
                'name' => 'status',
                'label' => Mage::helper('orderstatus')->__('Order Status Title'),
                'title' => Mage::helper('orderstatus')->__('Order Status Title'),
                'class' => 'required-entry',
                'values' => $statuses,
                'required' => true,
                'value' => $model->getStatus(), // Set the selected value based on the model data
            )
        );

        $fieldset->addField(
            'short_order',
            'text',
            array(
                'name' => 'short_order',
                'label' => Mage::helper('orderstatus')->__('Sort Order'),
                'title' => Mage::helper('orderstatus')->__('Sort Order'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'is_active',
            'select',
            array(
                'label' => Mage::helper('orderstatus')->__('Is Active'),
                'title' => Mage::helper('orderstatus')->__('Is Active'),
                'name' => 'is_active',
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('orderstatus')->__('Enabled'),
                    '2' => Mage::helper('orderstatus')->__('Disabled'),
                ),
                'value' => $model->getIsActive(),
            )
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
    public function getTabLabel()
    {
        return Mage::helper('orderstatus')->__('General Information');
    }
    public function getTabTitle()
    {
        return Mage::helper('orderstatus')->__('General Information');
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