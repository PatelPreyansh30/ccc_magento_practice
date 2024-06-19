<?php

class Ccc_Ticket_Block_Adminhtml_Abstract extends Mage_Adminhtml_Block_Template
{
    public function getTickets($id = null, $pageSize = 5, $curPage = 1)
    {
        $collection = Mage::getModel('ccc_ticket/ticket')->getCollection();

        if ($this->getRequest()->getParam('page')) {
            $curPage = $this->getRequest()->getParam('page');
        }
        $collection->setPageSize($pageSize)->setCurPage($curPage);

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

        if (
            $this->getRequest()->isAjax()
            && $this->getRequest()->isPost()
            && $this->getRequest()->getParam('custom_filter')
        ) {
            $customFilterData = json_decode($this->getRequest()->getParam('custom_filter'), true);
            if (isset($customFilterData['assign_to']) && !empty($customFilterData['assign_to'])) {
                $collection->addFieldToFilter('admin_user', ['in' => $customFilterData['assign_to']]);
            };
            if (isset($customFilterData['status']) && !empty($customFilterData['status'])) {
                $collection->addFieldToFilter('status', ['in' => $customFilterData['status']]);
            };
            if (isset($customFilterData['created_date']) && !empty($customFilterData['created_date'])) {
                $date = new DateTime('Asia/Calcutta');
                $date = $date->modify("-{$customFilterData['created_date']} day");
                $date = $date->format('Y-m-d');
                $collection->addFieldToFilter('main_table.created_at', ['gteq' => $date]);
            };
            if (isset($customFilterData['last_comment_by']) && !empty($customFilterData['last_comment_by'])) {
                $commentCollection = Mage::getModel('ccc_ticket/comment')->getCollection();
                $commentCollection->getSelect()
                    ->join(
                        array('max_dates' => new Zend_Db_Expr('(SELECT ticket_id, MAX(created_at) AS max_created_at FROM ' . $commentCollection->getTable('ccc_ticket/comment') . ' GROUP BY ticket_id)')),
                        'main_table.ticket_id = max_dates.ticket_id AND main_table.created_at = max_dates.max_created_at',
                        array('max_created_at')
                    )
                    ->where('main_table.user_id = ?', $customFilterData['last_comment_by']);
                $ticketIds = $commentCollection->getColumnValues('ticket_id');
                $collection->addFieldToFilter('ticket_id', ['in' => $ticketIds]);
            };
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
    public function getUsers()
    {
        return Mage::getModel('admin/user')->getCollection();
    }
    public function getStatus()
    {
        return Mage::getModel('ccc_ticket/status')->getCollection();
    }
}
