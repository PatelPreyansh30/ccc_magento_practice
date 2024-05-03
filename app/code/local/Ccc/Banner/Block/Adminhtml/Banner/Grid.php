<?php
class Ccc_Banner_Block_Adminhtml_Banner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('bannerBlockGrid');
        $this->setDefaultSort('block_identifier');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('banner/banner')->getCollection();

        if (!(Mage::getSingleton('admin/session')->isAllowed('banner/banner/showall'))) {
            $collection->setOrder('banner_id', 'DESC')
                ->getSelect()
                ->limit(5);
            foreach ($collection as $_collection) {

            }
        }

        $this->setCollection($collection);
        // $this->getCollection()->load();
        return parent::_prepareCollection();
    }

    public function addColumn($columnId, $column)
    {
        if ($column['is_allowed'] == false) {
            return;
        }
        return parent::addColumn($columnId, $column);
    }
    protected function _prepareColumns()
    {
        $aclUrl = 'banner/banner/columns/';
        $baseUrl = $this->getUrl();

        $this->addColumn(
            'banner_id',
            array(
                'header' => Mage::helper('banner')->__('ID'),
                'width' => '50px',
                'type' => 'number',
                'index' => 'banner_id',
                'is_allowed' => Mage::getSingleton('admin/session')->isAllowed($aclUrl . 'banner_id'),
            )
        );

        $this->addColumn(
            'banner_image',
            array(
                'header' => Mage::helper('banner')->__('Banner Name'),
                'align' => 'left',
                'index' => 'banner_image',
                'is_allowed' => Mage::getSingleton('admin/session')->isAllowed($aclUrl . 'banner_image'),
            )
        );

        $this->addColumn(
            'status',
            array(
                'header' => Mage::helper('banner')->__('Status'),
                'align' => 'left',
                'index' => 'status',
                'type' => 'options',
                'is_allowed' => Mage::getSingleton('admin/session')->isAllowed($aclUrl . 'banner_status'),
                'options' => array(
                    '1' => Mage::helper('banner')->__('Enabled'),
                    '0' => Mage::helper('banner')->__('Disabled'),
                ),
            )
        );

        $this->addColumn(
            'show_on',
            array(
                'header' => Mage::helper('banner')->__('Show On'),
                'align' => 'left',
                'index' => 'show_on',
                'is_allowed' => Mage::getSingleton('admin/session')->isAllowed($aclUrl . 'banner_show_on'),
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
        $this->addFieldToFilter('banner_id', $value);
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('banner_id' => $row->getId()));
    }
    // MAss Actions 
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('banner_id');
        $this->getMassactionBlock()->setFormFieldName('banner_id'); // Change to 'banner_id'

        $this->getMassactionBlock()->addItem(
            'delete',
            array(
                'label' => Mage::helper('banner')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('banner')->__('Are you sure you want to delete selected banners?')
            )
        );

        $statuses = Mage::getSingleton('banner/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem(
            'status',
            array(
                'label' => Mage::helper('banner')->__('Change status'),
                'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('banner')->__('Status'),
                        'values' => $statuses
                    )
                )
            )
        );

        Mage::dispatchEvent('banner_adminhtml_banner_grid_prepare_massaction', array('block' => $this));
        return $this;
    }

}
