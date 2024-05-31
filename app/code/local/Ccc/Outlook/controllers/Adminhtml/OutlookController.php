<?php

class Ccc_Outlook_Adminhtml_OutlookController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('outlook');
        return $this;
    }
    public function indexAction()
    {
        $this->_initAction();
        $this->_title($this->__("Configuration"));
        $this->renderLayout();
    }
    public function newAction()
    {
        $this->_forward('edit');
    }
    public function editAction()
    {
        $this->_title($this->__('ccc_outlook'))->_title($this->__('Configuration'));
        $id = $this->getRequest()->getParam('entity_id');
        $model = Mage::getModel('outlook/configuration');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ccc_outlook')->__('This Configuration no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Configuration'));
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        Mage::register('ccc_outlook', $model);
        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('ccc_outlook')->__('Edit Configuration') : Mage::helper('ccc_outlook')->__('New Configuration'), $id ? Mage::helper('ccc_outlook')->__('Edit Configuration') : Mage::helper('ccc_outlook')->__('New Configuration'))
            ->renderLayout();
    }
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
                $model = Mage::getModel('outlook/configuration');

                if ($id = $this->getRequest()->getParam('entity_id')) {
                    $model->load($id);
                }
                $model->setData($data);
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('ccc_outlook')->__('The Configuration has been saved.')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('entity_id' => $model->getId(), '_current' => true));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('ccc_outlook')->__('An error occurred while saving the order status.')
                );
            }
            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('entity_id' => $this->getRequest()->getParam('entity_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('entity_id');
        if (!$id) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('ccc_outlook')->__('Unable to find an Configuration to delete.')
            );
            $this->_redirect('*/*/');
            return;
        }
        try {
            $model = Mage::getModel('outlook/configuration');
            $model->load($id);
            $model->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('ccc_outlook')->__('The Configuration has been deleted.')
            );

            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/edit', array('entity_id' => $id));
            return;
        }
    }
    public function massStatusAction()
    {
        $id = $this->getRequest()->getParam('entity_id');
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
}
