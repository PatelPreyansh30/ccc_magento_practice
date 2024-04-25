<?php
class Ccc_Orderstatus_Block_Adminhtml_Orderstatus_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'entity_id';
        $this->_controller = 'adminhtml_orderstatus';
        $this->_blockGroup = 'orderstatus';
        parent::__construct();

            $this->_updateButton('save', 'label', Mage::helper('orderstatus')->__('Save Order Status'));
            $this->_addButton('saveandcontinue', array(
                'label' => Mage::helper('adminhtml')->__('Save and Continue Edit'),
                'onclick' => 'saveAndContinueEdit(\'' . $this->_getSaveAndContinueUrl() . '\')',
                'class' => 'save',
            ), -100);

            $this->_updateButton('delete', 'label', Mage::helper('orderstatus')->__('Delete Order Status'));
    }
    public function getHeaderText()
    {
        if (Mage::registry('orderstatus')->getId()) {
            return Mage::helper('orderstatus')->__("Edit Order Status '%s'", $this->escapeHtml(Mage::registry('orderstatus')->getBannerImage()));
        } else {
            return Mage::helper('orderstatus')->__('New Order Status');
        }
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
}
