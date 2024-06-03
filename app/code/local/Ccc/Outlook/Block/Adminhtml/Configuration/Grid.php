<?php
class Ccc_Outlook_Block_Adminhtml_Configuration_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('configurationGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('outlook/configuration')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('ccc_outlook')->__('Entity ID'),
                'width' => '50px',
                'type' => 'number',
                'index' => 'entity_id',
            )
        );
        $this->addColumn(
            'user_name',
            array(
                'header' => Mage::helper('ccc_outlook')->__('User Name'),
                'align' => 'left',
                'index' => 'user_name',
                'type' => 'text',
            )
        );
        $this->addColumn(
            'client_id',
            array(
                'header' => Mage::helper('ccc_outlook')->__('Client Id'),
                'align' => 'left',
                'index' => 'client_id',
                'type' => 'text',
            )
        );
        $this->addColumn(
            'is_active',
            array(
                'header' => Mage::helper('ccc_outlook')->__('Is Active'),
                'align' => 'left',
                'index' => 'is_active',
                'type' => 'options',
                'options' => array(
                    '1' => Mage::helper('ccc_outlook')->__('Enabled'),
                    '0' => Mage::helper('ccc_outlook')->__('Disabled'),
                ),
            )
        );
        $this->addColumn(
            'delete',
            array(
                'header' => Mage::helper('ccc_outlook')->__('Delete'),
                'width' => '50px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('ccc_outlook')->__('Delete'),
                        'url' => array('base' => '*/*/delete'),
                        'field' => 'entity_id',
                        'data-column' => 'action',
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'is_system' => true,
            )
        );
        $this->addColumn(
            'action',
            array(
                'header' => Mage::helper('ccc_outlook')->__('Action'),
                'width' => '50px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('ccc_outlook')->__('View'),
                        'url' => array('base' => '*/*/edit'),
                        'field' => 'entity_id',
                        'data-column' => 'action',
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'is_system' => true,
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
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('entity_id');

        $this->getMassactionBlock()->addItem(
            'is_active',
            array(
                'label' => Mage::helper('ccc_outlook')->__('Change status'),
                'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'is_active',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('ccc_outlook')->__('Status'),
                        'values' => [1 => 'Yes', 0 => 'No']
                    )
                )
            )
        );
        return $this;
    }
}
