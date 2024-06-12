<?php
class Ccc_Ftp_Block_Adminhtml_Configuration_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('ftpConfigurationGrid');
        $this->setDefaultSort('config_id');
        $this->setDefaultDir('ASC');
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ccc_ftp/configuration')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn(
            'config_id',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Configuration Id'),
                'index' => 'config_id',
                'type' => 'number'
            )
        );
        $this->addColumn(
            'user_name',
            array(
                'header' => Mage::helper('ccc_ftp')->__('User Name'),
                'index' => 'user_name',
                'type' => 'text',
            )
        );
        $this->addColumn(
            'password',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Password'),
                'index' => 'password',
                'type' => 'text'
            )
        );
        $this->addColumn(
            'host',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Host'),
                'index' => 'host',
                'type' => 'text',
            )
        );
        $this->addColumn(
            'port',
            array(
                'header' => Mage::helper('ccc_ftp')->__('Port'),
                'index' => 'port',
                'type' => 'text'
            )
        );
        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('config_id' => $row->getId()));
    }
}
