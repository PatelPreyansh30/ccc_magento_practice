<?php

class Ccc_Orderstock_Adminhtml_OrderstockController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('orderstock');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__("Orderstock"));
        $this->_initAction();
        $this->renderLayout();
    }
    public function newAction()
    {
        $this->_forward('edit');
    }
    public function editAction()
    {
        $this->_title($this->__('Order Stock'));

        $id = $this->getRequest()->getParam('entity_id');
        $model = Mage::getModel('orderstock/manufacturer');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('orderstock')->__('This manufacturer no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Manufacturer'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('orderstock', $model);

        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('orderstock')->__('Edit Order Stock') : Mage::helper('orderstock')->__('New Order Stock'), $id ? Mage::helper('orderstock')->__('Edit Order Stock') : Mage::helper('orderstock')->__('New Order Status'))
            ->renderLayout();
    }
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
                $model = Mage::getModel('orderstock/manufacturer');

                if ($id = $this->getRequest()->getParam('entity_id')) {
                    $model->load($id);
                }
                $model->setData($data);
                $model->save();

                $brandModel = Mage::getModel('orderstock/brand');
                foreach ($data['brand'] as $value) {
                    $brandModel->setData([
                        'mfr_id' => $model->getId(),
                        'brand_id' => $value,
                    ]);
                    $brandModel->save();
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('orderstock')->__('The Order Status has been saved.')
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
                    Mage::helper('orderstatus')->__('An error occurred while saving the order status.')
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
                Mage::helper('orderstatus')->__('Unable to find an order status to delete.')
            );
            $this->_redirect('*/*/');
            return;
        }

        try {
            $model = Mage::getModel('orderstatus/orderstatus');
            $model->load($id);
            $model->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('orderstatus')->__('The order status has been deleted.')
            );

            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

            $this->_redirect('*/*/edit', array('entity_id' => $id));
            return;
        }
    }
}