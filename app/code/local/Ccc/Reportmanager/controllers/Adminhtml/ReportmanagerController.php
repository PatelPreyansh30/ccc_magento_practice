<?php

class Ccc_Reportmanager_Adminhtml_ReportmanagerController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('grid');
        return $this;
    }
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('grid');
        $this->_title($this->__("Grid"));
        $this->renderLayout();
    }
    public function newAction()
    {
        $this->_forward('edit');
    }
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        Mage::getModel('reportmanager/reportmanager')
            ->load($id)
            ->delete();
        $this->_getSession()->addSuccess(
            $this->__('Record have been deleted.')
        );
        $this->_redirect('*/*/index');
    }
    public function saveAction()
    {
        $data = $this->getRequest()->getParams();
        $reportType = $this->getRequest()->getParam('report_type');
        unset($data['form_key']);
        unset($data['isAjax']);
        unset($data['report_type']);
        $userId = Mage::getSingleton('admin/session')->getUser()->getId();

        $model = Mage::getModel('reportmanager/reportmanager');
        $collection = Mage::getModel('reportmanager/reportmanager')
            ->getCollection()
            ->addFieldToFilter('user_id', $userId)
            ->addFieldToFilter('report_type', $reportType)
            ->getFirstItem();

        if ($collection) {
            $collection->setData('filter_data', json_encode($data))
                ->setData('is_active', 1)
                ->setData('report_type', $reportType)
                ->setData('user_id', $userId)
                ->setData('updated_at', date('Y-m-d H:i:s'))
                ->save();
        } else {
            $model->setData('filter_data', json_encode($data))
                ->setData('is_active', 1)
                ->setData('report_type', $reportType)
                ->setData('user_id', $userId)
                ->save();
        }
        if ($reportType == 'product') {
            $this->_redirect('*/catalog_product/index');
        } else {
            $this->_redirect('*/customer/index');
        }
    }
    public function massStatusAction()
    {
        $id = $this->getRequest()->getParam('id');
        $status = $this->getRequest()->getParam('status');

        if (!is_array($id)) {
            $id = array($id);
        }

        try {
            foreach ($id as $_id) {
                $model = Mage::getModel('reportmanager/reportmanager')->load($_id);
                if ($model->getIsActive() != $status) {
                    $model->setIsActive($status)->save();
                }
            }
            if ($status == 1) {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been enabled.', count($id))
                );
            } else {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been disabled.', count($id))
                );
            }
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }

        $this->_redirect('*/*/index');
    }
    public function loadFilterAction()
    {
        $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        $collection = Mage::getModel('reportmanager/reportmanager')
            ->getCollection()
            ->addFieldToFilter('user_id', $userId)
            ->addFieldToSelect('report_type')
            ->addFieldToSelect('filter_data')
            ->getData();
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($collection));
    }
}
