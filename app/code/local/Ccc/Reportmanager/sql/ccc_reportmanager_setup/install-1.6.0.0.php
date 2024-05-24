<?php
$installer = $this;
$installer->startSetup();

$tableNameManufacturer = $installer->getTable('ccc_filter_report');
if ($installer->getConnection()->isTableExists($tableNameManufacturer) !== true) {
    $tableManufacturer = $installer->getConnection()
        ->newTable($tableNameManufacturer)
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'Id')
        ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
        ), 'User Id')
        ->addColumn('report_type', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Report Type')
        ->addColumn('filter_data', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
        ), 'Filter Data')
        ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable' => false,
        ), 'Is Active')
        ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable' => false,
        ), 'Is Active')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
        ), 'Created At')
        ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE,
        ), 'Updated At')
        ->setComment('Reportmanager Table');
    $installer->getConnection()->createTable($tableManufacturer);
}

$installer->endSetup();
