<?php

class Ccc_Orderstatus_Block_Adminhtml_Orderstatus_Edit_Tab_Options extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function getDeleteButtonHtml()
    {
        return $this->getChildHtml('delete_button');
    }
    protected function _prepareLayout()
    {
        $this->setChild(
            'delete_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label' => Mage::helper('orderstatus')->__('Delete'),
                        'class' => 'delete delete-option'
                    )
                )
        );

        $this->setChild(
            'add_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label' => Mage::helper('orderstatus')->__('Add Option'),
                        'class' => 'add',
                        'id' => 'add_new_option_button'
                    )
                )
        );
        return parent::_prepareLayout();
    }

    public function getOptionData()
    {
        $model = Mage::registry('orderstatus'); // Replace 'your_model' with the appropriate model variable name

        // Retrieve old option values from the database
        $oldOptions = $model->getTotalRange();
        if ($oldOptions != null) {// Replace 'getOptionData()' with the actual method to retrieve option data
            $data = explode(",", $oldOptions);
            $result = array(
                'option' => array(
                    'value' => array(),
                    'order' => array()
                )
            );

            foreach ($data as $index => $value) {
                $parts = explode('-', $value);
                $result['option']['value']['option_' . $index] = $parts[0];
                $result['option']['order']['option_' . $index] = $parts[1];
            }

            return $result;
        }
    }
    public function getAddNewButtonHtml()
    {
        return $this->getChildHtml('add_button');
    }
    public function getTabLabel()
    {
        return Mage::helper('orderstatus')->__('Manage Label / Options');
    }
    public function getTabTitle()
    {
        return Mage::helper('orderstatus')->__('Manage Label / Options');
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

