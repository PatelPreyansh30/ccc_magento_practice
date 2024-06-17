<?php

class Ccc_Ticket_Block_Adminhtml_Menu extends Mage_Adminhtml_Block_Page_Menu
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('ccc/ticket/menu.phtml');
        $this->_url = Mage::getModel('adminhtml/url');
        $this->setCacheTags(array(self::CACHE_TAGS));
    }
    public function getUsers()
    {
        return Mage::getModel('admin/user')->getCollection();
    }
    public function getStatus()
    {
        return Mage::getModel('ccc_ticket/status')->getCollection();
    }
    public function getCurrentUserId()
    {
        return Mage::getSingleton('admin/session')->getUser()->getId();
    }
    public function getSaveUrl()
    {
        return $this->getUrl('*/ticket/save');
    }
}
