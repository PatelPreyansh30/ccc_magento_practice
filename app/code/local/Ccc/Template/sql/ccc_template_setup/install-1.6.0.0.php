<?php
$installer = $this;
$installer->startSetup();

$tableNameManufacturer = $installer->getTable('exception_template');
if ($installer->getConnection()->isTableExists($tableNameManufacturer) !== true) {
    $tableManufacturer = $installer->getConnection()
        ->newTable($tableNameManufacturer)
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'Entity Id')
        ->addColumn('exception_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
        ), 'Exception Id')
        ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
        ), 'Name')
        ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable' => false,
            'default' => 1,
        ), 'Is Active')
        ->addColumn('can_apply_on_existing_order', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable' => false,
            'default' => 0,
        ), 'Can Apply On Existing Order')
        ->addColumn('created_by', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
        ), 'Created By')
        ->addColumn('updated_by', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
        ), 'Updated By')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
        ), 'Created At')
        ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE,
        ), 'Updated At')
        ->setComment('Exception Template');
    $installer->getConnection()->createTable($tableManufacturer);
}

$installer->endSetup();
