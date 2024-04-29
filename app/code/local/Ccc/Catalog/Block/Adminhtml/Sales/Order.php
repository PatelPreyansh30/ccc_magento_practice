<?php
class Ccc_Catalog_Block_Adminhtml_Sales_Order extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'sales_order';
        $this->_headerText = Mage::helper('sales')->__('Orders');
        $this->_addButtonLabel = Mage::helper('sales')->__('Create New Order');
        parent::__construct();
        if (!Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/create')) {
            $this->_removeButton('add');
        }
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/sales_order_create/start');
    }
    public function getOrderStatus()
    {
        $collection = Mage::getModel('orderstatus/orderstatus')->getCollection();
        // $collection->addFieldToSelect(array('status', 'total_range'));
        return $collection;
    }
    public function getCount($status)
    {
        $collection = Mage::getModel('sales/order')->getCollection();
        $collection->addFieldToFilter('status', $status);
        return $collection->getSize();
    }
    public function getRange($totalRange, $status)
    {
        $rangeAarray = array_reverse(explode(',', $totalRange));
        $options = '';
        foreach ($rangeAarray as $range) {
            $options .= '<span class="order-status" onclick="getDropdownText(\'' . $range . '\',\'' . $status . '\')">' . $range . " - " . $this->getRangeCount($status, $range) . '</span>';
        }
        return $options;
    }
    public function getRangeCount($status, $range)
    {
        $array = explode('-', $range);
        $limit = $array[1] - $array[0] + 1;
        $collection = Mage::getModel('sales/order')->getCollection();
        $limitedSubsetSelect = $collection->getConnection()->select()
            ->from(
                $collection->getTable('sales/order'),
                array('*')
            )
            ->limit($limit, $array[0] - 1);
        $limitedSubsetTable = $collection->getConnection()->quoteIdentifier('limited_subset');

        $collection->getSelect()->reset()
            ->from(
                array($limitedSubsetTable => new Zend_Db_Expr('(' . $limitedSubsetSelect . ')')),
                array('*')
            )
            ->where('status = ?', $status);

        return $collection->getSize();
    }
}
