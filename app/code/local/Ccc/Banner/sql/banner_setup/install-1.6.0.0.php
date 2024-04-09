<?php
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('banner');
if ($installer->getConnection()->isTableExists($tableName) !== true) {
    $table = $installer->getConnection()
        ->newTable($tableName)
        ->addColumn('banner_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Block ID')
        ->addColumn('banner_image', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Block Title')
        ->addColumn('status', Varien_Db_Ddl_Table::TYPE_TINYINT, 4, array(
            'nullable' => false,
        ), 'Block String Identifier')
        ->addColumn('show_on', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false
        ), 'Block Content')
        ->setComment('CMS Block Table');
    $installer->getConnection()->createTable($table);
}

$installer->endSetup();
