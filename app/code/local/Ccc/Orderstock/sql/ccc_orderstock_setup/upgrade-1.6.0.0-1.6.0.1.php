<?php
$installer = $this;
$installer->startSetup();

$tableNameManufacturerBrand = $installer->getTable('ccc_manufacturer_brand');
if ($installer->getConnection()->isTableExists($tableNameManufacturerBrand)) {
    $connection = $installer->getConnection();

    $connection->addIndex(
        $tableNameManufacturerBrand,
        $installer->getIdxName(
            'ccc_manufacturer_brand',
            ['brand_id'],
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        ['brand_id'],
        Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
    );

    $installer->endSetup();
}