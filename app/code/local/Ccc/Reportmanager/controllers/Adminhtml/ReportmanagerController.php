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
        $this->_initAction();
        $this->_title($this->__("Report Manager"));
        $this->renderLayout();
    }

    public function index2Action()
    {
        $this->_initAction();
        $this->_title($this->__("Report Manager"));
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

        $collection = Mage::getModel('reportmanager/reportmanager')
            ->getCollection()
            ->addFieldToFilter('user_id', $userId)
            ->addFieldToFilter('report_type', $reportType)
            ->getFirstItem();

        $collection->setData('filter_data', json_encode($data))
            ->setData('is_active', 1)
            ->setData('report_type', $reportType)
            ->setData('user_id', $userId)
            ->unsetData('updated_at')
            ->save();
    }
    public function massStatusAction()
    {
        $id = $this->getRequest()->getParam('id');
        $status = $this->getRequest()->getParam('is_active');

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

    protected function _isAllowed()
    {
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'index':
                $aclResource = 'system/reportmanager/grid';
                break;
            case 'index2':
                $aclResource = 'system/reportmanager/grid2';
                break;
            default:
                $aclResource = 'system/reportmanager';
                break;
        }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }
}
