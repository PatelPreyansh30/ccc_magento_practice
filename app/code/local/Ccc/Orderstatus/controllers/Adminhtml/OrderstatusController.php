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
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
                $model = Mage::getModel('orderstatus/orderstatus');

                if ($id = $this->getRequest()->getParam('entity_id')) {
                    $model->load($id);
                }

                if (isset($data['option']) && !empty($data['option'])) {
                    $result = [];

                    // Iterate over the 'value' and 'order' arrays
                    foreach ($data['option']['value'] as $key => $value) {
                        if ($data['option']['delete'][$key] != 1) {
                            // Check if the corresponding key exists in the 'order' array
                            if (isset($data['option']['order'][$key])) {
                                // Concatenate the value from 'value' and 'order' arrays with a hyphen
                                $result[] = $value . '-' . $data['option']['order'][$key];
                            }
                        }
                    }
                    $output = implode(',', $result);
                    $data['total_range'] = $output;

                    unset($data['option']);
                }
                $model->setData($data);

                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('orderstatus')->__('The Order Status has been saved.')
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