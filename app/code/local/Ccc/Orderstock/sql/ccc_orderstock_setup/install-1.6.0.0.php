<?php
$installer = $this;
$installer->startSetup();

$tableNameManufacturer = $installer->getTable('ccc_manufacturer');
if (!($installer->getConnection()->isTableExists($tableNameManufacturer))) {
    $tableManufacturer = $installer->getConnection()
        ->newTable($tableNameManufacturer)
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'Entity ID')
        ->addColumn('manufacturer_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Manufacturer Name')
        ->addColumn('email', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => true,
        ), 'Email')
        ->addColumn('street', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => true,
        ), 'Street')
        ->addColumn('city', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => true,
        ), 'City')
        ->addColumn('state', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => true,
        ), 'State')
        ->addColumn('country', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => true,
        ), 'Country')
        ->addColumn('zipcode', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => true,
        ), 'Zipcode')
        ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable' => false,
            'default' => '1',
        ), 'Is Active')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
        ), 'Created At')
        ->addColumn('created_by', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => true,
        ), 'Created By')
        ->setComment('Manufacturer Table');
    $installer->getConnection()->createTable($tableManufacturer);
}

$tableNameManufacturerBrand = $installer->getTable('ccc_manufacturer_brand');
if (!($installer->getConnection()->isTableExists($tableNameManufacturerBrand))) {
    $tableManufacturerBrand = $installer->getConnection()
        ->newTable($tableNameManufacturerBrand)
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'Entity ID')
        ->addColumn('mfr_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
            'unsigned' => true,
        ), 'Manufacturer ID')
        ->addColumn('brand_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
            'unsigned' => true,
        ), 'Brand ID')
        ->addForeignKey(
            $installer->getFkName('ccc_manufacturer_brand', 'mfr_id', 'ccc_manufacturer', 'entity_id'),
            'mfr_id',
            $installer->getTable('ccc_manufacturer'),
            'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE,
            Varien_Db_Ddl_Table::ACTION_CASCADE
        )
        ->setComment('Manufacturer Brand Table');
    $installer->getConnection()->createTable($tableManufacturerBrand);
}

$installer->endSetup();
