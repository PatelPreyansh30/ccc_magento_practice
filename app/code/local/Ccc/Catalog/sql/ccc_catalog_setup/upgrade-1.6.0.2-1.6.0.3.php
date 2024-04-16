<?php
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('sales/quote_item');

$installer->getConnection()
    ->changeColumn(
        $tableName,
        'brand',
        'brand_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'length' => 11,
            'comment' => 'Brand ID'
        )
    );

$installer->getConnection()
    ->changeColumn(
        $tableName,
        'shipping_type',
        'shipping_type_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'length' => 11,
            'comment' => 'Shipping Type ID'
        )
    );

$installer->endSetup();
