<?php
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('ccc_outlook_configuration');
if ($installer->getConnection()->isTableExists($tableName) == true) {
    $installer->getConnection()->dropColumn($tableName, 'last_readed_date');
    $installer->getConnection()
        ->addColumn(
            $tableName,
            'skip_email_count',
            array(
                'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'length' => 11,
                'comment' => 'Skip Email Count'
            )
        );
}

$installer->endSetup();