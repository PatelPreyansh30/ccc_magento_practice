<?php
$installer = $this;
$installer->startSetup();

$attributeCode = 'sold_count';
$attributeLabel = 'Sold Count';

$data = array(
    'attribute_code' => $attributeCode,
    'backend_type' => 'int',
    'frontend_input' => 'text',
    'default' => '0',
    'frontend_label' => array($attributeLabel),
    'is_global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'is_required' => false,
    'is_configurable' => false,
    'apply_to' => 'simple,configurable',
    'is_visible_on_front' => true,
    'is_searchable' => false,
    'is_filterable' => false,
    'is_comparable' => false,
    'is_used_for_promo_rules' => false,
    'is_html_allowed_on_front' => true,
);

$installer->addAttribute('catalog_product', $attributeCode, $data);

$installer->endSetup();
