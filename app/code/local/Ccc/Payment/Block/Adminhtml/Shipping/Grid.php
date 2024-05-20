<?php

class Ccc_Payment_Block_Adminhtml_Shipping_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('shippingmethodGrid');
        $this->setDefaultSort('method_code');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }
    protected function _prepareCollection()
    {
        $collection = new Varien_Data_Collection();
        $shippingMethods = Mage::getSingleton('shipping/config')->getAllCarriers();

        foreach ($shippingMethods as $code => $carrier) {
            if ($code == 'whiteglovedelivery') {
                $carrierData = new Varien_Object();
                $configData = Mage::getStoreConfig("carriers/$code/amount");

                if ($configData) {
                    $methods = unserialize($configData);
                    $formattedAmounts = [];
                    foreach ($methods as $key => $method) {
                        $formattedAmounts[] = "{$method['from']} - {$method['to']} = {$method['price']}";
                    }
                    $carrierData->setData('method_amount', implode(', ', $formattedAmounts));
                }

                $carrierData->setData('method_code', $code);
                $carrierData->setData('method_title', Mage::getStoreConfig("carriers/$code/title"));
                $carrierData->setData('description', Mage::getStoreConfig("carriers/$code/description"));

                $collection->addItem($carrierData);
            }
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }


    protected function _prepareColumns()
    {
        $this->addColumn('method_code', array(
            'header' => Mage::helper('ccc_payment')->__('Method Code'),
            'index' => 'method_code',
        )
        );
        $this->addColumn('method_title', array(
            'header' => Mage::helper('ccc_payment')->__('Method Title'),
            'index' => 'method_title',
        )
        );
        $this->addColumn('description', array(
            'header' => Mage::helper('ccc_payment')->__('Description'),
            'index' => 'description',
        )
        );
        $this->addColumn('method_amount', array(
            'header' => Mage::helper('ccc_payment')->__('Method amount'),
            'index' => 'method_amount',
        )
        );
        $this->addColumn('action', array(
            'header' => Mage::helper('ccc_payment')->__('Action'),
            'width' => '100px',
            'sortable' => false,
            'filter' => false,
            'renderer' => 'Ccc_Payment_Block_Adminhtml_Shipping_Renderer_Button',
        )
        );

        return parent::_prepareColumns();
    }
}