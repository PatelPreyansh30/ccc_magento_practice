<?php
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('sales_order_status_count'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Entity ID')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
    ), 'Status')
    ->addColumn('short_order', Varien_Db_Ddl_Table::TYPE_SMALLINT, 5, array(
        'nullable' => false,
    ), 'Short Order')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
        'nullable' => false,
    ), 'Is Active')
    ->addColumn('total_range', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false,
    ), 'Total Range')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => false,
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ), 'Created At')
    ->addColumn('created_by', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false,
    ), 'Created By')
    ->setComment('Order status Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();