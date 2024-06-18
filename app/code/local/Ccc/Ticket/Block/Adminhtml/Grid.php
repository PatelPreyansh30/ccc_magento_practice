<?php
class Ccc_Ticket_Block_Adminhtml_Grid extends Ccc_Ticket_Block_Adminhtml_Abstract
{
    public function getTableHead()
    {
        return [
            ['column' => 'ticket_id', 'label' => 'Id'],
            ['column' => 'title', 'label' => 'Title'],
            ['column' => 'description', 'label' => 'Description'],
            ['column' => 'assign_to', 'label' => 'Assign To'],
            ['column' => 'assign_by', 'label' => 'Assign By'],
            ['column' => 'status_label', 'label' => 'Status'],
            ['column' => 'priority', 'label' => 'Priority'],
        ];
    }
}
