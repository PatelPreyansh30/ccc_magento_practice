<?php
class Ccc_Reportmanager_Block_Adminhtml_Reportmanager_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('reportmanagerGrid');
        $this->setDefaultSort('block_identifier');
        $this->setDefaultDir('ASC');
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('reportmanager/reportmanager')->getCollection();
        if ($this->getRequest()->getParam('isAjax')) {
            $userid = $this->getRequest()->getParam('id');
            $collection->addFieldToFilter('user_id', $userid);
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    // protected function _prepareCollection()
    // {
    //     $collection = Mage::getModel('reportmanager/reportmanager')->getCollection();
    //     $this->setCollection($collection);
    //     return parent::_prepareCollection();
    // }
    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            array(
                'header' => Mage::helper('ccc_reportmanager')->__('Id'),
                'width' => '50px',
                'type' => 'number',
                'index' => 'id',
            )
        );
        $this->addColumn(
            'user_id',
            array(
                'header' => Mage::helper('ccc_reportmanager')->__('User Id'),
                'align' => 'left',
                'index' => 'user_id',
                'type' => 'text',
            )
        );
        $this->addColumn(
            'report_type',
            array(
                'header' => Mage::helper('ccc_reportmanager')->__('Report Type'),
                'align' => 'left',
                'index' => 'report_type',
                'type' => 'text',
            )
        );
        $this->addColumn(
            'filter_data',
            array(
                'header' => Mage::helper('ccc_reportmanager')->__('Filter Data'),
                'align' => 'left',
                'index' => 'filter_data',
                'type' => 'text',
            )
        );
        $this->addColumn(
            'is_active',
            array(
                'header' => Mage::helper('ccc_reportmanager')->__('Is Active'),
                'align' => 'left',
                'index' => 'is_active',
                'type' => 'options',
                'options' => array(
                    '1' => Mage::helper('ccc_reportmanager')->__('Enabled'),
                    '0' => Mage::helper('ccc_reportmanager')->__('Disabled'),
                ),
            )
        );
        $this->addColumn(
            'action',
            array(
                'header' => Mage::helper('ccc_reportmanager')->__('Action'),
                'width' => '50px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('ccc_reportmanager')->__('Delete'),
                        'url' => array('base' => '*/*/delete'),
                        'field' => 'id',
                        'data-column' => 'action',
                    )
                ),
                'filter' => false,
                'sortable' => false,
            )
        );
        return parent::_prepareColumns();
    }

    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');

        $this->getMassactionBlock()->addItem(
            'is_active',
            array(
                'label' => Mage::helper('ccc_reportmanager')->__('Change status'),
                'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'is_active',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('ccc_reportmanager')->__('Status'),
                        'values' => [1 => 'Yes', 0 => 'No']
                    )
                )
            )
        );
        return $this;
    }
}
