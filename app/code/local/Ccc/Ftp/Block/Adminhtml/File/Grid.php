<?php
class Ccc_Ftp_Block_Adminhtml_File_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('ftpFileGrid');
        $this->setDefaultSort('file_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ccc_ftp/files')->getCollection();

        $select = $collection->getSelect();
        $columns = [
            'file_id' => 'file_id',
            'user_name' => 'CFC.user_name',
            'file_name' => 'file_name',
            'received_date' => 'received_date'
        ];

        $select->join(
            array('CFC' => Mage::getSingleton('core/resource')->getTableName('ccc_ftp/configuration')),
            'CFC.config_id = main_table.config_id',
            ['']
        );
        $select->reset(Zend_Db_Select::COLUMNS)->columns($columns);

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn(
            'file_id',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Config_id'),
                'type' => 'number',
                'index' => 'file_id',
            )
        );
        $this->addColumn(
            'user_name',
            array(
                'header' => Mage::helper('ccc_ftp')->__('User Name'),
                'type' => 'text',
                'index' => 'user_name',
            )
        );
        $this->addColumn(
            'file_name',
            array(
                'header' => Mage::helper('ccc_ftp')->__('File Name'),
                'type' => 'text',
                'index' => 'file_name',
            )
        );
        $this->addColumn(
            'received_date',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Received Date'),
                'type' => 'date',
                'index' => 'received_date',
            )
        );

        return parent::_prepareColumns();
    }
}
