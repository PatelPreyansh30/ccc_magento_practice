<?php
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('ccc_ftp_files');

if ($installer->getConnection()->isTableExists($tableName) !== true) {
    $tableName = $installer->getConnection()
        ->newTable($tableName)
        ->addColumn('file_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'File ID')
        ->addColumn('config_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
        ), 'Config Id')
        ->addColumn('file_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'File Name')
        ->addColumn('path', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Path')
        ->addColumn('received_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
        ), 'Received At')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
        ), 'Created At')
        ->addForeignKey(
            $installer->getFkName('ccc_ftp_files', 'config_id', 'ccc_ftp_configuration', 'config_id'),
            'config_id',
            $installer->getTable('ccc_ftp_configuration'),
            'config_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE,
            Varien_Db_Ddl_Table::ACTION_CASCADE
        )
        ->setComment('Ccc Ftp File Table');
    $installer->getConnection()->createTable($tableName);
}

$installer->endSetup();