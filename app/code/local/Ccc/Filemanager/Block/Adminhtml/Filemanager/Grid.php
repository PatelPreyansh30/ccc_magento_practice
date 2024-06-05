<?php
class Ccc_Filemanager_Block_Adminhtml_Filemanager_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('filemanagerGrid');
    }
    protected function _prepareCollection()
    {
        if ($this->getRequest()->getParam('isAjax') == true) {
            $path = $this->getRequest()->getParam('value');
            $collection = Mage::getModel('ccc_filemanager/filemanager')
                ->addTargetDir($path)
                ->loadData();
            $this->setCollection($collection);
            return parent::_prepareCollection();
        }
    }
    protected function _prepareColumns()
    {
        $this->addColumn(
            'created_date',
            array(
                'header' => Mage::helper('ccc_filemanager')->__('Created Date'),
                'index' => 'created_date',
                'type' => 'datetime',
            )
        );
        $this->addColumn(
            'filename',
            array(
                'header' => Mage::helper('ccc_filemanager')->__('Filename'),
                'index' => 'filename',
                'type' => 'text',
            )
        );
        $this->addColumn(
            'folderpath',
            array(
                'header' => Mage::helper('ccc_filemanager')->__('Folder Path'),
                'index' => 'folderpath',
                'type' => 'text',
            )
        );
        $this->addColumn(
            'extension',
            array(
                'header' => Mage::helper('ccc_filemanager')->__('Extension'),
                'align' => 'left',
                'index' => 'extension',
                'type' => 'text',
            )
        );
        $this->addColumn(
            'action',
            array(
                'header' => Mage::helper('ccc_filemanager')->__('Action'),
                'filter' => false,
                'sortable' => false,
                'renderer' => 'Ccc_Filemanager_Block_Adminhtml_Filemanager_Renderer_Action',
            )
        );
        return parent::_prepareColumns();
    }
}