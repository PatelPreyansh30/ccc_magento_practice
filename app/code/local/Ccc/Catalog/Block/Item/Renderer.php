<?php

class Ccc_Catalog_Block_Item_Renderer extends Mage_Checkout_Block_Cart_Item_Renderer
{
    public function getBrandName($brandId)
    {
        return Mage::getModel('catalog/product')
            ->getResource()
            ->getAttribute('brand')
            ->getSource()
            ->getOptionText($brandId);
    }
    public function getShippingName($shippingId)
    {
        return Mage::getModel('catalog/product')
            ->getResource()
            ->getAttribute('shipping_type')
            ->getSource()
            ->getOptionText($shippingId);
    }
}