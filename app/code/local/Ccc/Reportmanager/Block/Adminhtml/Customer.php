<?php
class Ccc_Reportmanager_Block_Adminhtml_Customer extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'customer';
        $this->_headerText = Mage::helper('customer')->__('Manage Customers');
        $this->_addButtonLabel = Mage::helper('customer')->__('Add New Customer');
        if (Mage::getStoreConfig('ccc_reportmanager/options/reportmanager')) {
            $this->_addButton(
                'save_report',
                array(
                    'label' => Mage::helper('catalog')->__('Save Report'),
                    'onclick' => "customerGridJsObject.saveReport()",
                    'class' => 'save-report',
                    'id' => 'save-report-btn',
                )
            );
        }
        parent::__construct();
    }

}
