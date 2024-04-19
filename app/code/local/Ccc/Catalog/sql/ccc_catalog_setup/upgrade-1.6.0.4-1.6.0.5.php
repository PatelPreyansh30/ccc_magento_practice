<?php

$installer = $this;

$installer->startSetup();

$table = $installer->getTable("sales/quote_address");

$installer->getConnection()
    ->addColumn($table, 'address_proof', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'comment' => "Address Proof"
    )
    );

$table = $installer->getTable("sales/order_address");

$installer->getConnection()
    ->addColumn($table, 'address_proof', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'comment' => "Address Proof"
    )
    );


$installer->endSetup();