<?php

class Ccc_Orderstatus_Adminhtml_OrderstatusController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('system');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__("Orderstatus"));
        $this->_initAction();
        $this->renderLayout();
    }
    public function newAction()
    {
        $this->_forward('edit');
    }
    public function editAction()
    {
        $this->_title($this->__('Order Status'));

        $id = $this->getRequest()->getParam('entity_id');
        $model = Mage::getModel('orderstatus/orderstatus');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('orderstatus')->__('This order status no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Order Status'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('orderstatus', $model);

        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('orderstatus')->__('Edit Order Status') : Mage::helper('orderstatus')->__('New Order Status'), $id ? Mage::helper('orderstatus')->__('Edit Order Status') : Mage::helper('orderstatus')->__('New Order Status'))
            ->renderLayout();
    }
}