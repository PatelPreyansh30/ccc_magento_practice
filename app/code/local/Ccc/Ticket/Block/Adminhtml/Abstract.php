<?php

class Ccc_Ticket_Block_Adminhtml_Abstract extends Mage_Adminhtml_Block_Template
{
    public function getTickets($id = null)
    {
        $collection = Mage::getModel('ccc_ticket/ticket')->getCollection();
        if (
            $this->getRequest()->isAjax()
            && $this->getRequest()->isPost()
            && $this->getRequest()->getParam('filter_data')
        ) {
            $filterData = json_decode($this->getRequest()->getParam('filter_data'), true);
            foreach ($filterData as $key => $value) {
                $collection
                    ->addFieldToFilter($key, ['like' => "%{$value}%"]);
            }
        };

        if (!is_null($id)) {
            $collection->addFieldToFilter('ticket_id', $id);
        }

        $select = $collection->getSelect();
        $columns = [
            'ticket_id' => 'ticket_id',
            'title' => 'title',
            'assign_to_id' => 'admin_user',
            'assign_by_id' => 'assign_by',
            'description' => 'description',
            'priority' => 'priority',
            'created_date' => 'created_at',
            'updated_date' => 'updated_at',
            'status_label' => 'S.label',
            'status_code' => 'S.code',
            'status_color' => 'S.color_code',
            'assign_to' => 'AT.username',
            'assign_by' => 'AB.username',
        ];

        $select->joinLeft(
            array('AB' => Mage::getSingleton('core/resource')->getTableName('admin/user')),
            'AB.user_id = main_table.assign_by',
            ['username']
        );
        $select->joinLeft(
            array('AT' => Mage::getSingleton('core/resource')->getTableName('admin/user')),
            'AT.user_id = main_table.admin_user',
            ['username']
        );
        $select->joinLeft(
            array('S' => Mage::getSingleton('core/resource')->getTableName('ccc_ticket/status')),
            'S.code = main_table.status',
            ['code', 'label']
        );
        $select->reset(Zend_Db_Select::COLUMNS)->columns($columns);

        if (
            $this->getRequest()->isAjax()
            && $this->getRequest()->isPost()
            && $this->getRequest()->getParam('sorting_data')
        ) {
            $sortingData = json_decode($this->getRequest()->getParam('sorting_data'), true);
            foreach ($sortingData as $key => $value) {
                $collection->setOrder($key, $value);
            }
        } else {
            $collection->setOrder('ticket_id', 'ASC');
        };

        if (!is_null($id)) {
            return $collection->getFirstItem();
        }
        return $collection;
    }
}
