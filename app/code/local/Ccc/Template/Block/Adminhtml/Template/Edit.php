<?php
class Ccc_Template_Block_Adminhtml_Template_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'entity_id';
        $this->_controller = 'adminhtml_template';
        $this->_blockGroup = 'ccc_template';

        $this->_updateButton('save', 'label', Mage::helper('ccc_template')->__('Save Template'));
        $this->_updateButton('delete', 'label', Mage::helper('ccc_template')->__('Delete Template'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('template_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'template_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'template_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        // if (Mage::registry('template') && Mage::registry('template')->getId()) {
            // return Mage::helper('ccc_template')->__("Edit Template '%s'", $this->escapeHtml(Mage::registry('template')->getName()));
        // } else {
            return Mage::helper('ccc_template')->__('New Template');
        // }
    }
}
