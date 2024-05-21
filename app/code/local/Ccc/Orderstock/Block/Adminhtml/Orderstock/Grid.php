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
        $collection = Mage::getModel('orderstock/manufacturer')->getCollection();
        $select = $collection->getSelect();
        $select->joinLeft(
            array('cmb' => Mage::getSingleton('core/resource')->getTableName('orderstock/brand')),
            'cmb.mfr_id = main_table.entity_id',
            [
                'brand_id' => 'cmb.brand_id'
            ]
        );
        $select->joinLeft(
            ['eaov' => Mage::getSingleton('core/resource')->getTableName('eav_attribute_option_value')],
            'eaov.option_id = cmb.brand_id',
            ['brand_name' => new Zend_Db_Expr('GROUP_CONCAT(DISTINCT eaov.value SEPARATOR ", ")')]
        )
        ->group('main_table.entity_id');
        
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
        $this->addColumn(
            'manufacturer_name',
            array(
                'header' => Mage::helper('orderstock')->__('Manufacturer Name'),
                'type' => 'text',
                'index' => 'manufacturer_name',
                'column_css_class' => 'editable',
            )
        );
        $this->addColumn(
            'email',
            array(
                'header' => Mage::helper('orderstock')->__('Email'),
                'type' => 'text',
                'index' => 'email',
                'column_css_class' => 'editable',
            )
        );
        $this->addColumn(
            'brand',
            array(
                'header' => Mage::helper('orderstock')->__('Brand Name'),
                'type' => 'text',
                'index' => 'brand_name',
            )
        );
        $this->addColumn(
            'is_active',
            array(
                'header' => Mage::helper('orderstock')->__('Is Active'),
                'align' => 'left',
                'index' => 'is_active',
                'type' => 'options',
                'options' => array(
                    '1' => Mage::helper('orderstock')->__('Enabled'),
                    '0' => Mage::helper('orderstock')->__('Disabled'),
                ),
            )
        );
        $this->addColumn(
            'edit',
            array(
                'header' => Mage::helper('orderstock')->__('Action'),
                'align' => 'left',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('orderstock')->__('Edit'),
                        // 'url' => array(
                        //     'base' => '*/*/edit',
                        // ),
                        'field' => 'entity_id',
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'edit',
                'renderer' => 'orderstock/adminhtml_orderstock_grid_renderer_editbutton',
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
    // public function getRowUrl($row)
    // {
    //     return $this->getUrl('*/*/edit', array('entity_id' => $row->getId()));
    // }
}
