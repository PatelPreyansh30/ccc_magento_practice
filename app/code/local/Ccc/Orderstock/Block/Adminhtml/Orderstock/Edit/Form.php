<?php
class Ccc_Orderstock_Block_Adminhtml_Orderstock_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('entity_id');
        $this->setTitle(Mage::helper('orderstock')->__('Banner Information'));
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('orderstock');
        $isEdit = ($model && $model->getId());

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post', 'enctype' => 'multipart/form-data')
        );

        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('orderstock')->__('General Information'), 'class' => 'fieldset-wide'));

        if ($model->getEntityId()) {
            $fieldset->addField(
                'entity_id',
                'hidden',
                array(
                    'name' => 'entity_id',
                )
            );
        }
        $fieldset->addField(
            'manufacturer_name',
            'text',
            array(
                'name' => 'manufacturer_name',
                'label' => Mage::helper('orderstock')->__('Manufacturer Name'),
                'title' => Mage::helper('orderstock')->__('Manufacturer Name'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'email',
            'text',
            array(
                'name' => 'email',
                'label' => Mage::helper('orderstock')->__('Email'),
                'title' => Mage::helper('orderstock')->__('Email'),
                'required' => true,
                'class' => 'validate-email',
            )
        );
        $fieldset->addField(
            'street',
            'text',
            array(
                'name' => 'street',
                'label' => Mage::helper('orderstock')->__('Street Address'),
                'title' => Mage::helper('orderstock')->__('Street Address'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'city',
            'text',
            array(
                'name' => 'city',
                'label' => Mage::helper('orderstock')->__('City'),
                'title' => Mage::helper('orderstock')->__('City'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'state',
            'text',
            array(
                'name' => 'state',
                'label' => Mage::helper('orderstock')->__('State'),
                'title' => Mage::helper('orderstock')->__('State'),
                'required' => true,
            )
        );

        $countryCollection = Mage::getModel('directory/country')->getResourceCollection()
            ->load();

        $countryOptions = [];
        foreach ($countryCollection as $country) {
            $countryOptions[$country->getCountryId()] = $country->getName();
        }
        $fieldset->addField(
            'country',
            'select',
            array(
                'label' => Mage::helper('orderstock')->__('Country'),
                'title' => Mage::helper('orderstock')->__('Country'),
                'name' => 'country',
                'required' => true,
                'options' => $countryOptions,
            )
        );
        $fieldset->addField(
            'zipcode',
            'text',
            array(
                'name' => 'zipcode',
                'label' => Mage::helper('orderstock')->__('Zipcode'),
                'title' => Mage::helper('orderstock')->__('Zipcode'),
                'required' => true,
                'class' => 'validate-number',
            )
        );

        $attributeCode = 'brand';
        $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);
        $options = $attribute->getSource()->getAllOptions();
        $brandOptions = [];
        foreach ($options as $option) {
            if ($option['value'] == '')
                continue;
            $brandOptions[] = [
                'value' => $option['value'],
                'label' => $option['label'],
            ];
        }
        $fieldset->addField(
            'brand',
            'multiselect',
            array(
                'name' => 'brand',
                'label' => Mage::helper('orderstock')->__('Brand'),
                'title' => Mage::helper('orderstock')->__('Brand'),
                'required' => true,
                'values' => $brandOptions,
            )
        );

        $fieldset->addField(
            'is_active',
            'select',
            array(
                'label' => Mage::helper('orderstock')->__('Is Active'),
                'title' => Mage::helper('orderstock')->__('Is Active'),
                'name' => 'manufacturer[is_active]',
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('orderstock')->__('Enabled'),
                    '0' => Mage::helper('orderstock')->__('Disabled'),
                ),
            )
        );
        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
