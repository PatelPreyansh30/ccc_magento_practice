<?php
class Ccc_Banner_Block_Adminhtml_Banner_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'banner_id';
        $this->_controller = 'adminhtml_banner';
        $this->_blockGroup = 'banner';
        parent::__construct();

        if ($this->_isAllowedAction('save')) {
            $this->_updateButton('save', 'label', Mage::helper('banner')->__('Save Banner'));
            $this->_addButton('saveandcontinue', array(
                'label' => Mage::helper('adminhtml')->__('Save and Continue Edit'),
                'onclick' => 'saveAndContinueEdit(\'' . $this->_getSaveAndContinueUrl() . '\')',
                'class' => 'save',
            ), -100);
        } else {
            $this->_removeButton('save');
        }

        if ($this->_isAllowedAction('delete')) {
            $this->_updateButton('delete', 'label', Mage::helper('banner')->__('Delete Banner'));
        } else {
            $this->_removeButton('delete');
        }
    }
    public function getHeaderText()
    {
        if (Mage::registry('banner')->getId()) {
            return Mage::helper('banner')->__("Edit Banner '%s'", $this->escapeHtml(Mage::registry('banner')->getBannerImage()));
        } else {
            return Mage::helper('banner')->__('New Banner');
        }
    }
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')
            ->isAllowed('banner/banner/actions/' . $action);
    }
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl(
            '*/*/save',
            array(
                '_current' => true,
                'back' => 'edit',
                'active_tab' => '{{tab_id}}'
            )
        );
    }
    protected function _prepareLayout()
    {
        $tabsBlock = $this->getLayout()->getBlock('banner_edit_tabs');
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
