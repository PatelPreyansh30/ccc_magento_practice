<?php
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('sales/quote_item');

$installer->getConnection()
    ->addColumn(
        $tableName,
        'brand',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'length' => 255,
            'comment' => 'Brand'
        )
    );

$installer->getConnection()
    ->addColumn(
        $tableName,
        'shipping_type',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'length' => 255,
            'comment' => 'Shipping Type'
        )
    );

$installer->endSetup();
