<?php
$installer = $this;
$installer->startSetup();

$tableNameManufacturer = $installer->getTable('ccc_ftp_configuration');
if ($installer->getConnection()->isTableExists($tableNameManufacturer) !== true) {
    $tableManufacturer = $installer->getConnection()
        ->newTable($tableNameManufacturer)
        ->addColumn('config_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'Configuration ID')
        ->addColumn('user_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'User Name')
        ->addColumn('password', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Password')
        ->addColumn('host', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Host Name')
        ->addColumn('port', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Host Name')
        ->setComment('Ccc Ftp Configuration');
    $installer->getConnection()->createTable($tableManufacturer);
}

$installer->endSetup();