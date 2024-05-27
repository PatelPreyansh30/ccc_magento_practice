<?php
class Ccc_Template_Block_Adminhtml_Template_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('templateGrid');
        $this->setDefaultSort('block_identifier');
        $this->setDefaultDir('ASC');
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ccc_template/template')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('ccc_template')->__('Id'),
                'width' => '50px',
                'type' => 'number',
                'index' => 'entity_id',
            )
        );
        $this->addColumn(
            'exception_id',
            array(
                'header' => Mage::helper('ccc_template')->__('Exception Id'),
                'width' => '50px',
                'type' => 'number',
                'index' => 'exception_id',
            )
        );
        $this->addColumn(
            'name',
            array(
                'header' => Mage::helper('ccc_template')->__('Template Name'),
                'align' => 'left',
                'index' => 'name',
            )
        );
        $this->addColumn(
            'is_active',
            array(
                'header' => Mage::helper('ccc_template')->__('Is Active'),
                'index' => 'is_active',
                'type' => 'options',
                'options' => array(
                    1 => Mage::helper('ccc_template')->__('Active'),
                    0 => Mage::helper('ccc_template')->__('Inactive')
                ),
            )
        );
        $this->addColumn(
            'created_by',
            array(
                'header' => Mage::helper('ccc_template')->__('Created By'),
                'type' => 'text',
                'index' => 'created_by',
            )
        );
        $this->addColumn(
            'updated_by',
            array(
                'header' => Mage::helper('ccc_template')->__('Updated By'),
                'type' => 'text',
                'index' => 'updated_by',
            )
        );
        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('ccc_template')->__('Created At'),
                'index' => 'created_at',
                'type' => 'datetime',
            )
        );
        $this->addColumn(
            'updated_at',
            array(
                'header' => Mage::helper('ccc_template')->__('Updated At'),
                'index' => 'updated_at',
                'type' => 'datetime',
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
                'label' => Mage::helper('ccc_template')->__('Change status'),
                'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'is_active',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('ccc_template')->__('Status'),
                        'values' => [1 => 'Yes', 0 => 'No']
                    )
                )
            )
        );
        return $this;
    }
}
