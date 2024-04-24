<?php
class Ccc_Orderstatus_Block_Adminhtml_Orderstatus_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('orderstatusBlockGrid');
        $this->setDefaultSort('block_identifier');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('orderstatus/orderstatus')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('ccc_orderstatus')->__('ID'),
                'width' => '50px',
                'type' => 'number',
                'index' => 'entity_id',
            )
        );

        $this->addColumn(
            'status',
            array(
                'header' => Mage::helper('ccc_orderstatus')->__('Status'),
                'align' => 'left',
                'index' => 'status',
            )
        );

        $this->addColumn(
            'total_range',
            array(
                'header' => Mage::helper('ccc_orderstatus')->__('Total Range'),
                'align' => 'left',
                'index' => 'total_range',
                'type' => 'text',
            )
        );

        $this->addColumn(
            'is_active',
            array(
                'header' => Mage::helper('ccc_orderstatus')->__('Active'),
                'align' => 'left',
                'index' => 'is_active',
                'type' => 'options',
                'options' => [
                    '1' => Mage::helper('ccc_orderstatus')->__('Enabled'),
                    '0' => Mage::helper('ccc_orderstatus')->__('Disabled'),
                ],
            )
        );

        $this->addColumn(
            'created_by',
            array(
                'header' => Mage::helper('ccc_orderstatus')->__('Created By'),
                'align' => 'left',
                'index' => 'created_by',
                'type' => 'text',
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
    // MAss Actions 
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('entity_id'); // Change to 'banner_id'

        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label' => Mage::helper('ccc_orderstatus')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('ccc_orderstatus')->__('Are you sure you want to delete selected banners?')
            )
        );

        $statuses = Mage::getSingleton('banner/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label' => Mage::helper('ccc_orderstatus')->__('Change status'),
                'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('ccc_orderstatus')->__('Status'),
                        'values' => $statuses
                    )
                )
            )
        );

        Mage::dispatchEvent('banner_adminhtml_banner_grid_prepare_massaction', array('block' => $this));
        return $this;
    }

}
