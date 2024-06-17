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
            'part_number' => 'main_table.part_number',
            'length' => 'length',
            'depth' => 'depth',
            'height' => 'height',
            'weight' => 'weight',
            'status' => new Zend_Db_Expr("
            CASE
                WHEN CXNP.part_number IS NOT NULL AND CXNP.new_part_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) THEN 'New'
                WHEN CXDP.part_number IS NOT NULL THEN 'Discontinue'
                ELSE 'Regular'
            END
            "),
            'date' => new Zend_Db_Expr("
            CASE
                WHEN CXNP.part_number IS NOT NULL THEN CXNP.new_part_date
                WHEN CXDP.part_number IS NOT NULL THEN CXDP.discontinue_part_date
            END
            "),
        ];

        $select->joinLeft(
            array('CXNP' => Mage::getSingleton('core/resource')->getTableName('ccc_ftp/newpart')),
            'CXNP.entity_id = main_table.entity_id',
            ['']
        );
        $select->joinLeft(
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
                'filter_condition_callback' => array($this, '_filterPartNumberCallback'),
            )
        );
        $this->addColumn(
            'depth',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Depth'),
                'type' => 'number',
                'index' => 'depth',
            )
        );
        $this->addColumn(
            'height',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Height'),
                'type' => 'number',
                'index' => 'height',
            )
        );
        $this->addColumn(
            'length',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Length'),
                'type' => 'number',
                'index' => 'length',
            )
        );
        $this->addColumn(
            'weight',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Weight'),
                'type' => 'number',
                'index' => 'weight',
            )
        );
        $this->addColumn(
            'status',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Status'),
                'type' => 'options',
                'index' => 'status',
                'align' => 'right',
                'options' => [
                    'new'=>'New',
                    'regular'=>'Regular',
                    'discontinue'=> 'Discontinue',
                ],
                'filter_condition_callback' => array($this, '_filterStatusCallback'),
            )
        );
        $this->addColumn(
            'date',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Date'),
                'type' => 'datetime',
                'index' => 'date',
                'align' => 'right',
            )
        );

        return parent::_prepareColumns();
    }
    protected function _filterPartNumberCallback($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }

        $collection->getSelect()->where(
            "main_table.part_number LIKE ?",
            "%$value%"
        );

        return $this;
    }
    protected function _filterStatusCallback($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }

        $collection->getSelect()->where(
            "CASE
                WHEN CXNP.entity_id IS NOT NULL THEN 'New'
                WHEN CXDP.entity_id IS NOT NULL THEN 'Discontinue'
                ELSE 'Regular'
             END = ?",
            $value
        );

        return $this;
    }
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}
