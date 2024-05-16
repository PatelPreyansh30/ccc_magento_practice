<?php
class Ccc_Catalog_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('sales_order_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _getCollectionClass()
    {
        return 'sales/order_grid_collection';
    }

    protected function _prepareCollection()
    {
        $status = '';
        $start = 0;
        $end = 0;
        $limit = 0;
        if ($this->getRequest()->getParam('isAjax')) {
            $status = $this->getRequest()->getParam('status');
            $start = $this->getRequest()->getParam('start');
            $end = $this->getRequest()->getParam('end');
            $limit = $end - $start + 1;
        }
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $select = $collection->getSelect();
        $select->join(
            array('rc' => Mage::getSingleton('core/resource')->getTableName('sales/order')),
            'rc.increment_id = main_table.increment_id',
            [
                'delivery_note' => 'rc.delivery_note',
                'address_validation_required' => 'rc.address_validation_required'
            ]
        );
        if ($limit != 0) {
            $limitedSubsetSelect = $collection->getConnection()->select()
                ->from(
                    array('sog' => $collection->getTable('sales/order_grid')),
                    array('*')
                )
                ->join(
                    array('so' => $collection->getTable('sales/order')),
                    'sog.increment_id = so.increment_id',
                    array('delivery_note' => 'so.delivery_note')
                )
                ->limit($limit, $start - 1);

            $limitedSubsetTable = $collection->getConnection()->quoteIdentifier('limited_subset');

            $collection->getSelect()->reset()
                ->from(
                    array($limitedSubsetTable => new Zend_Db_Expr('(' . $limitedSubsetSelect . ')')),
                    array('*')
                )
                ->where('status = ?', $status);
        } elseif ($status) {
            $collection->addFieldToFilter('main_table.status', $status);
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn(
            'real_order_id',
            array(
                'header' => Mage::helper('sales')->__('Order #'),
                'width' => '80px',
                'type' => 'text',
                'index' => 'increment_id',
            )
        );

        // if (!Mage::app()->isSingleStoreMode()) {
        //     $this->addColumn(
        //         'store_id',
        //         array(
        //             'header' => Mage::helper('sales')->__('Purchased From (Store)'),
        //             'index' => 'store_id',
        //             'type' => 'store',
        //             'store_view' => true,
        //             'display_deleted' => true,
        //             'escape' => true,
        //         )
        //     );
        // }

        $this->addColumn(
            'created_at',
            array(
                'header' => Mage::helper('sales')->__('Purchased On'),
                'index' => 'created_at',
                'type' => 'datetime',
                'width' => '100px',
            )
        );

        $this->addColumn(
            'billing_name',
            array(
                'header' => Mage::helper('sales')->__('Bill to Name'),
                'index' => 'billing_name',
            )
        );

        // $this->addColumn(
        //     'shipping_name',
        //     array(
        //         'header' => Mage::helper('sales')->__('Ship to Name'),
        //         'index' => 'shipping_name',
        //     )
        // );

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/view/delivery_note')) {
            $this->addColumn(
                'delivery_note',
                array(
                    'header' => Mage::helper('sales')->__('Delivery Note'),
                    'index' => 'delivery_note',
                    'renderer' => 'ccc_catalog/adminhtml_sales_order_grid_renderer_textarea',
                )
            );
        }

        $this->addColumn('address_validation_required', array(
            'header' => Mage::helper('sales')->__('Address Validation'),
            'index' => 'address_validation_required',
            'type' => 'options',
            'width' => '70px',
            'renderer' => 'Ccc_Catalog_Block_Adminhtml_Renderer_Validation',
            'options' => array(
                0 => Mage::helper('sales')->__('N/A'),
                1 => Mage::helper('sales')->__('Validate'),
                2 => Mage::helper('sales')->__('Validated'),
            ),
        )
        );

        // $this->addColumn(
        //     'base_grand_total',
        //     array(
        //         'header' => Mage::helper('sales')->__('G.T. (Base)'),
        //         'index' => 'base_grand_total',
        //         'type' => 'currency',
        //         'currency' => 'base_currency_code',
        //     )
        // );

        $this->addColumn(
            'grand_total',
            array(
                'header' => Mage::helper('sales')->__('G.T. (Purchased)'),
                'index' => 'grand_total',
                'type' => 'currency',
                'currency' => 'order_currency_code',
            )
        );

        $this->addColumn(
            'status',
            array(
                'header' => Mage::helper('sales')->__('Status'),
                'index' => 'status',
                'type' => 'options',
                'width' => '70px',
                'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
            )
        );

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            $this->addColumn(
                'action',
                array(
                    'header' => Mage::helper('sales')->__('Action'),
                    'width' => '50px',
                    'type' => 'action',
                    'getter' => 'getId',
                    'actions' => array(
                        array(
                            'caption' => Mage::helper('sales')->__('View'),
                            'url' => array('base' => '*/sales_order/view'),
                            'field' => 'order_id',
                            'data-column' => 'action',
                        )
                    ),
                    'filter' => false,
                    'sortable' => false,
                    'index' => 'stores',
                    'is_system' => true,
                )
            );
        }
        $this->addRssList('rss/order/new', Mage::helper('sales')->__('New Order RSS'));

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('order_ids');
        $this->getMassactionBlock()->setUseSelectAll(false);

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/emailvalidation')) {
            $this->getMassactionBlock()->addItem('emailvalidation', array(
                'label' => Mage::helper('sales')->__('Email Validation'),
                'url' => $this->getUrl('*/sales_order/emailvalidation'),
            )
            );
        }

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/cancel')) {
            $this->getMassactionBlock()->addItem(
                'cancel_order',
                array(
                    'label' => Mage::helper('sales')->__('Cancel'),
                    'url' => $this->getUrl('*/sales_order/massCancel'),
                )
            );
        }

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/hold')) {
            $this->getMassactionBlock()->addItem(
                'hold_order',
                array(
                    'label' => Mage::helper('sales')->__('Hold'),
                    'url' => $this->getUrl('*/sales_order/massHold'),
                )
            );
        }

        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/unhold')) {
            $this->getMassactionBlock()->addItem(
                'unhold_order',
                array(
                    'label' => Mage::helper('sales')->__('Unhold'),
                    'url' => $this->getUrl('*/sales_order/massUnhold'),
                )
            );
        }

        $this->getMassactionBlock()->addItem(
            'pdfinvoices_order',
            array(
                'label' => Mage::helper('sales')->__('Print Invoices'),
                'url' => $this->getUrl('*/sales_order/pdfinvoices'),
            )
        );

        $this->getMassactionBlock()->addItem(
            'pdfshipments_order',
            array(
                'label' => Mage::helper('sales')->__('Print Packingslips'),
                'url' => $this->getUrl('*/sales_order/pdfshipments'),
            )
        );

        $this->getMassactionBlock()->addItem(
            'pdfcreditmemos_order',
            array(
                'label' => Mage::helper('sales')->__('Print Credit Memos'),
                'url' => $this->getUrl('*/sales_order/pdfcreditmemos'),
            )
        );

        $this->getMassactionBlock()->addItem(
            'pdfdocs_order',
            array(
                'label' => Mage::helper('sales')->__('Print All'),
                'url' => $this->getUrl('*/sales_order/pdfdocs'),
            )
        );

        $this->getMassactionBlock()->addItem(
            'print_shipping_label',
            array(
                'label' => Mage::helper('sales')->__('Print Shipping Labels'),
                'url' => $this->getUrl('*/sales_order_shipment/massPrintShippingLabel'),
            )
        );

        return $this;
    }

    // public function getRowUrl($row)
    // {
        // if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
        //     return $this->getUrl('*/sales_order/view', array('order_id' => $row->getId()));
        // }
        // return false;
    // }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

}
