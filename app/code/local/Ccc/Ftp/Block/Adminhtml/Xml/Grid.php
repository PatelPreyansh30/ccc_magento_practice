<?php
class Ccc_Ftp_Block_Adminhtml_Xml_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('ftpXmlGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ccc_ftp/master')->getCollection();

        $select = $collection->getSelect();
        $columns = [
            'entity_id' => 'entity_id',
            'part_number' => 'part_number',
            'length' => 'length',
            'depth' => 'depth',
            'height' => 'height',
            'weight' => 'weight',
            // 'status' => 'status',
        ];

        $select->join(
            array('CXNP' => Mage::getSingleton('core/resource')->getTableName('ccc_ftp/newpart')),
            'CXNP.entity_id = main_table.entity_id',
            ['']
        );
        $select->join(
            array('CXDP' => Mage::getSingleton('core/resource')->getTableName('ccc_ftp/discontinuepart')),
            'CXDP.entity_id = main_table.entity_id',
            ['']
        );
        $select->reset(Zend_Db_Select::COLUMNS)->columns($columns);

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Entity Id'),
                'type' => 'number',
                'index' => 'entity_id',
            )
        );
        $this->addColumn(
            'part_number',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Part Number'),
                'type' => 'text',
                'index' => 'part_number',
            )
        );
        $this->addColumn(
            'depth',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Depth'),
                'type' => 'text',
                'index' => 'depth',
            )
        );
        $this->addColumn(
            'height',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Height'),
                'type' => 'text',
                'index' => 'height',
            )
        );
        $this->addColumn(
            'length',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Length'),
                'type' => 'text',
                'index' => 'length',
            )
        );
        $this->addColumn(
            'weight',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Weight'),
                'type' => 'text',
                'index' => 'weight',
            )
        );
        $this->addColumn(
            'status',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Status'),
                'type' => 'text',
                'index' => 'status',
            )
        );

        return parent::_prepareColumns();
    }
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}
