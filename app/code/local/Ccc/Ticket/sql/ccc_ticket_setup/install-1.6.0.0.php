<?php
$installer = $this;
$installer->startSetup();

$tableName = $installer->getTable('ccc_ticket');
if ($installer->getConnection()->isTableExists($tableName) !== true) {
    $table = $installer->getConnection()
        ->newTable($tableName)
        ->addColumn('ticket_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'Ticket ID')
        ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Title')
        ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
        ), 'Description')
        ->addColumn('admin_user', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Admin User')
        ->addColumn('priority', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Priority')
        ->addColumn('status', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Status')
        ->addColumn('assign_by', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Assign By')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
        ), 'Created At')
        ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE,
        ), 'Updated At')
        ->setComment('Ccc Ticket');
    $installer->getConnection()->createTable($table);
}

$tableName = $installer->getTable('ccc_ticket_comment');
if ($installer->getConnection()->isTableExists($tableName) !== true) {
    $table = $installer->getConnection()
        ->newTable($tableName)
        ->addColumn('comment_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'Comment Id')
        ->addColumn('ticket_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
        ), 'Ticket Id')
        ->addColumn('comment', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable' => false,
        ), 'Comment')
        ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
        ), 'User Id')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
        ), 'Created At')
        ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE,
        ), 'Updated At')
        ->addForeignKey(
            $installer->getFkName('ccc_ticket_comment', 'ticket_id', 'ccc_ticket', 'ticket_id'),
            'ticket_id',
            $installer->getTable('ccc_ticket'),
            'ticket_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE,
            Varien_Db_Ddl_Table::ACTION_CASCADE
        )
        ->setComment('Ccc Ticket Comment Table');
    $installer->getConnection()->createTable($table);
}

$tableName = $installer->getTable('ccc_ticket_status');
if ($installer->getConnection()->isTableExists($tableName) !== true) {
    $table = $installer->getConnection()
        ->newTable($tableName)
        ->addColumn('status_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'nullable' => false,
            'primary' => true,
            'unsigned' => true,
        ), 'Status Id')
        ->addColumn('code', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Code')
        ->addColumn('label', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Label')
        ->addColumn('color_code', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Color Code')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
        ), 'Created At')
        ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'nullable' => false,
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE,
        ), 'Updated At')
        ->setComment('Ccc Ticket Status Table');
    $installer->getConnection()->createTable($table);
}

$installer->endSetup();
