<?php
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('ccc_outlook_attachment');
if ($installer->getConnection()->isTableExists($tableName) !== true) {
    $tableManufacturer = $installer->getConnection()
        ->newTable($tableName)
        ->addColumn('attachment_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'Attachment Id')
        ->addColumn('email_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
            'unsigned' => true,
        ), 'Email Id')
        ->addColumn('outlook_attachment_id', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
        ), 'Outlook Attachment Id')
        ->addColumn('original_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Original Name')
        ->addColumn('path', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Path')
        ->addForeignKey(
            $installer->getFkName('ccc_outlook_attachment', 'email_id', 'ccc_outlook_email', 'email_id'),
            'email_id',
            $installer->getTable('ccc_outlook_email'),
            'email_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE,
            Varien_Db_Ddl_Table::ACTION_CASCADE
        )
        ->setComment('Outlook Email Attachment Table');
    $installer->getConnection()->createTable($tableManufacturer);
}

$tableName = $installer->getTable('ccc_outlook_email');
if ($installer->getConnection()->isTableExists($tableName) == true) {
    $installer->getConnection()->dropColumn($tableName, 'api_key');
}

$tableName = $installer->getTable('ccc_outlook_configuration');
if ($installer->getConnection()->isTableExists($tableName) == true) {
    $installer->getConnection()
        ->addColumn(
            $tableName,
            'last_readed_date',
            array(
                'type' => Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
                'comment' => 'Last Readed Date'
            )
        );
    $installer->getConnection()
        ->addColumn(
            $tableName,
            'logged_in',
            array(
                'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'comment' => 'Logged In'
            )
        );
}
$installer->endSetup();
