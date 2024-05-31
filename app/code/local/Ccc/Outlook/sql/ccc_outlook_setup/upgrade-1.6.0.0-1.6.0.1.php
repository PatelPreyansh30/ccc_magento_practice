<?php
$installer = $this;
$installer->startSetup();

$tableNameManufacturer = $installer->getTable('ccc_outlook_email');
if ($installer->getConnection()->isTableExists($tableNameManufacturer) !== true) {
    $tableManufacturer = $installer->getConnection()
        ->newTable($tableNameManufacturer)
        ->addColumn('email_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'Email Id')
        ->addColumn('from', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'From')
        ->addColumn('subject', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
        ), 'Subject')
        ->addColumn('body', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
        ), 'Body')
        ->addColumn('api_key', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
        ), 'API Key')
        ->addColumn('has_attachment', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable' => false,
        ), 'Has Attachment')
        ->addColumn('received_date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
        ), 'Received At')
        ->setComment('Outlook Email Table');
    $installer->getConnection()->createTable($tableManufacturer);
}

$installer->endSetup();
