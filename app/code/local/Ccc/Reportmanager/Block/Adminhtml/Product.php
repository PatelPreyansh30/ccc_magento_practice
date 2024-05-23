<?php
class Ccc_Reportmanager_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('catalog/product.phtml');
    }
    protected function _prepareLayout()
    {
        $this->_addButton(
            'add_new',
            array(
                'label' => Mage::helper('catalog')->__('Add Product'),
                'onclick' => "setLocation('{$this->getUrl('*/*/new')}')",
                'class' => 'add'
            )
        );
        if (Mage::getStoreConfig('ccc_reportmanager/options/reportmanager')) {
            $this->_addButton(
                'save_report',
                array(
                    'label' => Mage::helper('catalog')->__('Save Report'),
                    'onclick' => "productGridJsObject.saveReport()",
                    'class' => 'save-report',
                    'id' => 'save-report-btn',
                )
            );
        }

        $this->setChild('grid', $this->getLayout()->createBlock('adminhtml/catalog_product_grid', 'product.grid'));
        return parent::_prepareLayout();
    }
    public function getAddNewButtonHtml()
    {
        return $this->getChildHtml('add_new_button');
    }
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }
    public function isSingleStoreMode()
    {
        if (!Mage::app()->isSingleStoreMode()) {
            return false;
        }
        return true;
    }
}
