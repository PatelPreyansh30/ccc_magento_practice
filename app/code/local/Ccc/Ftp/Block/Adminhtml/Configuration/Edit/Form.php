<?php
class Ccc_Ftp_Block_Adminhtml_Configuration_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('config_id');
        $this->setTitle(Mage::helper('ccc_ftp')->__('Configuration Information'));
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('ccc_ftp_config');
        $isEdit = ($model && $model->getId());

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post', 'enctype' => 'multipart/form-data')
        );

        $form->setHtmlIdPrefix('block_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('ccc_ftp')->__('User Information'), 'class' => 'fieldset-wide'));

        if ($model->getId()) {
            $fieldset->addField(
                'config_id',
                'hidden',
                array(
                    'name' => 'config_id',
                )
            );
        }
        $fieldset->addField(
            'user_name',
            'text',
            array(
                'name' => 'user_name',
                'label' => Mage::helper('ccc_ftp')->__('User Name'),
                'title' => Mage::helper('ccc_ftp')->__('User Name'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'password',
            'text',
            array(
                'name' => 'password',
                'label' => Mage::helper('ccc_ftp')->__('Password'),
                'title' => Mage::helper('ccc_ftp')->__('Password'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'host',
            'text',
            array(
                'name' => 'host',
                'label' => Mage::helper('ccc_ftp')->__('Host'),
                'title' => Mage::helper('ccc_ftp')->__('Host'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'port',
            'text',
            array(
                'name' => 'port',
                'label' => Mage::helper('ccc_ftp')->__('Port'),
                'title' => Mage::helper('ccc_ftp')->__('Port'),
                'required' => true,
            )
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
