<?php
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('ccc_outlook_configuration');
if ($installer->getConnection()->isTableExists($tableName) == true) {
    $installer->getConnection()->dropColumn($tableName, 'skip_email_count');
    $installer->getConnection()
        ->addColumn(
            $tableName,
            'last_readed_date',
            array(
                'type' => Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
                'nullable' => false,
                'comment' => 'Last Readed Date'
            )
        );
}

$installer->endSetup();