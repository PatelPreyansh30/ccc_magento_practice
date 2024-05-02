<?php
class Ccc_Orderstock_Block_Adminhtml_Orderstock_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('orderstockBlockGrid');
        $this->setDefaultSort('block_identifier');
        $this->setDefaultDir('ASC');
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('orderstock/brand')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('orderstock')->__('ID'),
                'width' => '50px',
                'type' => 'number',
                'index' => 'entity_id',
            )
        );
        return parent::_prepareColumns();
    }

    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection();
        $this->addFieldToFilter('entity_id', $value);
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('entity_id' => $row->getId()));
    }
}
