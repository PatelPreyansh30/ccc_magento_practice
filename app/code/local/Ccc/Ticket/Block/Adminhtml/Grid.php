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
    public function getStatusSelect()
    {
        $html = '<select name="status" class="grid_filter">';
        $html .= '<option value="">All</option>';
        foreach ($this->getStatus() as $status) {
            $html .= '<option value="' . $status->getCode() . '">' . $status->getLabel() . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    public function getAssignToSelect()
    {
        $html = '<select name="admin_user" class="grid_filter">';
        $html .= '<option value="">All</option>';
        foreach ($this->getUsers() as $user) {
            $html .= '<option value="' . $user->getId() . '">' . $user->getUsername() . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
    public function getAssignBySelect()
    {
        $html = '<select name="assign_by" class="grid_filter">';
        $html .= '<option value="">All</option>';
        foreach ($this->getUsers() as $user) {
            $html .= '<option value="' . $user->getId() . '">' . $user->getUsername() . '</option>';
        }
        $html .= '</select>';
        return $html;
    }
}
