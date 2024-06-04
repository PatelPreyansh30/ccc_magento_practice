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

        $eventModel = Mage::getModel('outlook/event');
        $eventCollection = $eventModel->getCollection()
            ->addFieldToFilter('config_id', $model->getId())
            ->setOrder('group_id', 'ASC');

        $eventsData = [];
        foreach ($eventCollection as $event) {
            $eventsData[$event->getGroupId()]['rows'][] = $event->getData();
        }
        Mage::register('event_data', $eventsData);

        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('ccc_outlook')->__('Edit Configuration') : Mage::helper('ccc_outlook')->__('New Configuration'), $id ? Mage::helper('ccc_outlook')->__('Edit Configuration') : Mage::helper('ccc_outlook')->__('New Configuration'))
            ->renderLayout();
    }
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            try {
                $id = $this->getRequest()->getParam('entity_id');
                $model = Mage::getModel('outlook/configuration');
                if ($id) {
                    $model->load($id);
                }
                $model->setData($data);
                $model->save();
                $eventmodel = Mage::getModel('outlook/event');
                $eventData = $this->getRequest()->getPost('event');

                // echo "<pre>";
                // print_r($eventData);
                // die;
                // Get existing group IDs for the current configuration
                if ($eventData) {
                    $existingGroupIds = $eventmodel->getCollection()
                        ->addFieldToFilter('config_id', $model->getId())
                        ->getColumnValues('group_id');

                    // Get group IDs from posted data
                    $postedGroupIds = array_column($eventData, 'group_id');

                    // Delete groups not present in posted data
                    foreach ($existingGroupIds as $existingGroupId) {
                        if (!in_array($existingGroupId, $postedGroupIds)) {
                            $eventCollection = $eventmodel->getCollection()
                                ->addFieldToFilter('config_id', $model->getId())
                                ->addFieldToFilter('group_id', $existingGroupId);
                            foreach ($eventCollection as $event) {
                                $event->delete();
                            }
                        }
                    }

                    // Get the current highest group_id for each configuration
                    $maxGroupId = $eventmodel->getCollection()
                        ->addFieldToFilter('config_id', $model->getId())
                        ->getSelect()
                        ->reset(Zend_Db_Select::COLUMNS)
                        ->columns('MAX(group_id) as max_group_id')
                        ->query()
                        ->fetchColumn();
                    $maxGroupId = $maxGroupId ? (int) $maxGroupId : 0;
                    // Save or update events for the groups present in posted data
                    foreach ($eventData as $rowData) {
                        if (isset($rowData['group_id']) && !empty($rowData['group_id'])) {
                            $groupId = $rowData['group_id'];
                            // Delete events not present in groupwise data
                            $eventCollection = $eventmodel->getCollection()
                                ->addFieldToFilter('config_id', $model->getId())
                                ->addFieldToFilter('group_id', $groupId);
                            $eventIds = $eventCollection->getColumnValues('event_id');
                            foreach ($eventIds as $eventId) {
                                if (!in_array($eventId, array_column($rowData['rows'], 'event_id'))) {
                                    $eventmodel->load($eventId)->delete();
                                }
                            }
                        } else {
                            // This is a new group without a group_id, increment the highest group_id
                            $groupId = ++$maxGroupId;
                        }
                        // Save or update events
                        foreach ($rowData['rows'] as $column) {
                            $eventmodel = Mage::getModel('outlook/event'); // Reinitialize for each row
                            // Check if 'event_id' is present for updating, otherwise treat as new event
                            if (!empty($column['event_id'])) {
                                $eventmodel->load($column['event_id']);
                            }
                            $eventmodel->setData($column);
                            $eventmodel->addData([
                                'event_name' => $rowData['event_name'],
                                'config_id' => $model->getId(),
                                'group_id' => $groupId,
                            ]);
                            $eventmodel->save();
                        }
                    }
                }
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
                Mage::logException($e); // Log the exception for debugging
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('ccc_outlook')->__('An error occurred while saving the configuration.')
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
                $model = Mage::getModel('outlook/configuration')->load($_id);
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
