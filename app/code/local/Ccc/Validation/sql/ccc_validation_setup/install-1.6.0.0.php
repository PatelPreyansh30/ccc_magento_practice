<?php
$installer = $this;
$installer->startSetup();

// $installer->run("
// ALTER TABLE `{$this->getTable('sales/order')}`
// ADD COLUMN `address_validation_required` TINYINT(1) DEFAULT 0 AFTER `status`,
// ADD COLUMN `validation_email_sent_count` INT DEFAULT 0 AFTER `address_validation_required`;
// ");

$installer->getConnection()
    ->addColumn(
        $installer->getTable('sales/order'),
        'address_validation_required',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_TINYINT,
            'nullable' => true,
            'default' => '0',
            'comment' => 'Address validation required'
        )
    );

$installer->getConnection()
    ->addColumn(
        $installer->getTable('sales/order'),
        'validation_email_sent_count',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'nullable' => true,
            'default' => '0',
            'comment' => 'Validation email sent count'
        )
    );

$installer->endSetup();
