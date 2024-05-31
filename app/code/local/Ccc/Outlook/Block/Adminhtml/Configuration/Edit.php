<?php
class Ccc_Outlook_Block_Adminhtml_Configuration_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'entity_id';
        $this->_controller = 'adminhtml_configuration';
        $this->_blockGroup = 'ccc_outlook';
        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('ccc_outlook')->__('Save Configuration'));
        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit(\'' . $this->_getSaveAndContinueUrl() . '\')',
            'class' => 'save',
        ), -100);

        $this->_updateButton('delete', 'label', Mage::helper('ccc_outlook')->__('Delete Configuration'));
    }
    public function getHeaderText()
    {
        if (Mage::registry('ccc_outlook')->getId()) {
            return Mage::helper('ccc_outlook')->__("Edit Configuration");
        } else {
            return Mage::helper('ccc_outlook')->__('New Configuration');
        }
    }
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current' => true,
            'back' => 'edit',
            'active_tab' => '{{tab_id}}'
        )
        );
    }
    protected function _prepareLayout()
    {
        $tabsBlock = $this->getLayout()->getBlock('grid_edit_tabs');
        if ($tabsBlock) {
            $tabsBlockJsObject = $tabsBlock->getJsObjectName();
            $tabsBlockPrefix = $tabsBlock->getId() . '_';
        } else {
            $tabsBlockJsObject = 'page_tabsJsTabs';
            $tabsBlockPrefix = 'page_tabs_';
        }

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('page_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'page_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'page_content');
                }
            }

            function saveAndContinueEdit(urlTemplate) {
                var tabsIdValue = " . $tabsBlockJsObject . ".activeTab.id;
                var tabsBlockPrefix = '" . $tabsBlockPrefix . "';
                if (tabsIdValue.startsWith(tabsBlockPrefix)) {
                    tabsIdValue = tabsIdValue.substr(tabsBlockPrefix.length)
                }
                var template = new Template(urlTemplate, /(^|.|\\r|\\n)({{(\w+)}})/);
                var url = template.evaluate({tab_id:tabsIdValue});
                editForm.submit(url);
            }
        ";
        return parent::_prepareLayout();
    }
}
