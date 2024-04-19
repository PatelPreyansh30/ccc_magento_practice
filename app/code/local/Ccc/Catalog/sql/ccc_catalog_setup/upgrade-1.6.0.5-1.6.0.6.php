<?php
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('sales/quote');
$installer->getConnection()
    ->addColumn(
        $tableName,
        'delivery_note',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment' => 'delivery_note'
        )
    );

$tableName = $installer->getTable('sales/order');
$installer->getConnection()
    ->addColumn(
        $tableName,
        'delivery_note',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'comment' => 'delivery_note'
        )
    );
$installer->endSetup();