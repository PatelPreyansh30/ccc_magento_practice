<?php
$installer = $this;
$installer->startSetup();

$attributeCode = 'shipping_type';
$attributeLabel = 'Shipping Type';

$data = array(
    'attribute_code' => $attributeCode,
    'user_defined' => true,
);

$installer->addAttribute('catalog_product', $attributeCode, $data);

$installer->endSetup();
