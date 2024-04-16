<?php
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('sales/order_item');

$installer->getConnection()
    ->addColumn(
        $tableName,
        'brand_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'length' => 11,
            'comment' => 'Brand Id'
        )
    );

$installer->getConnection()
    ->addColumn(
        $tableName,
        'shipping_type_id',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'length' => 11,
            'comment' => 'Shipping Type Id'
        )
    );

$installer->endSetup();
