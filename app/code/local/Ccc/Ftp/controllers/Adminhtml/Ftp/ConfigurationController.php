<?php

class Ccc_Ftp_Adminhtml_Ftp_ConfigurationController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('ftp');
        return $this;
    }
    public function indexAction()
    {
        $this->_initAction();
        $this->_title($this->__("FTP Configuration"));
        $this->renderLayout();
    }
    public function newAction()
    {
        $this->_forward('edit');
    }
    public function editAction()
    {
        $this->_title($this->__('ccc_ftp'))->_title($this->__('Ftp Configuration'));
        $id = $this->getRequest()->getParam('config_id');
        $model = Mage::getModel('ccc_ftp/configuration');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ccc_ftp')->__('This Configuration no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Configuration'));
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        Mage::register('ccc_ftp_config', $model);

        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('ccc_ftp')->__('Edit Configuration') : Mage::helper('ccc_ftp')->__('New Configuration'), $id ? Mage::helper('ccc_ftp')->__('Edit Configuration') : Mage::helper('ccc_ftp')->__('New Configuration'))
            ->renderLayout();
    }
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
                $id = $this->getRequest()->getParam('config_id');
                $model = Mage::getModel('ccc_ftp/configuration');
                if ($id) {
                    $model->load($id);
                }
                $model->setData($data);
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('ccc_ftp')->__('The Configuration has been saved.')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('config_id' => $model->getId(), '_current' => true));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::logException($e); // Log the exception for debugging
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('ccc_ftp')->__('An error occurred while saving the configuration.')
                );
            }
            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('config_id' => $this->getRequest()->getParam('config_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('config_id');
        if (!$id) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('ccc_ftp')->__('Unable to find an Configuration to delete.')
            );
            $this->_redirect('*/*/');
            return;
        }
        try {
            $model = Mage::getModel('ccc_ftp/configuration');
            $model->load($id);
            $model->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('ccc_ftp')->__('The Configuration has been deleted.')
            );

            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            $this->_redirect('*/*/edit', array('config_id' => $id));
            return;
        }
    }
}
