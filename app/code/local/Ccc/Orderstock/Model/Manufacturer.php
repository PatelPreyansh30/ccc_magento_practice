<?php

class Ccc_Orderstock_Model_Manufacturer extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('orderstock/manufacturer');
    }

    public function _beforeSave()
    {
        $this->setData(
            'created_by',
            Mage::getSingleton('admin/session')->getUser()->getId()
        );
    }
}