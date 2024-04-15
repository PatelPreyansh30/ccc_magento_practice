<?php
$installer = $this;
$installer->startSetup();

$attributeCode = 'shipping_type';
$attributeLabel = 'Shipping Type';

$data = array(
    'attribute_code' => $attributeCode,
    'backend_type' => 'int',
    'frontend_input' => 'select',
    'frontend_label' => array($attributeLabel),
    'source_model' => 'eav/entity_attribute_source_table',
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
    'option' => array(
        'values' => array(
            0 => 'Freight',
            1 => 'Express',
        )
    ),
);

$installer->addAttribute('catalog_product', $attributeCode, $data);

$installer->endSetup();
