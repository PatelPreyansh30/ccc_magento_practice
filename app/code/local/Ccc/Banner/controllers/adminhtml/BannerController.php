<?php

class Ccc_Banner_Adminhtml_BannerController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('Ccc_Banner');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__("banner"));
        $this->_initAction();
        $this->renderLayout();
    }
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }
    public function editAction()
    {
        $this->_title($this->__('banner'))->_title($this->__('Banner'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('banner_id');
        $model = Mage::getModel('banner/banner');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banner')->__('This banner no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Banner'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('banner', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('banner')->__('Edit Banner') : Mage::helper('banner')->__('New Banner'), $id ? Mage::helper('banner')->__('Edit Banner') : Mage::helper('banner')->__('New Banner'))
            ->renderLayout();
    }
    public function saveAction()
    {
        // Check if data sent
        if ($data = $this->getRequest()->getPost()) {
            // Initialize model and set data
            $model = Mage::getModel('banner/banner');

            if ($id = $this->getRequest()->getParam('banner_id')) {
                $model->load($id);
            }

            // Image upload handling
            try {
                if (!empty($_FILES['banner_image']['name'])) {
                    $uploader = new Varien_File_Uploader('banner_image');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(false);
                    $path = Mage::getBaseDir('media') . DS . 'banner' . DS;
                    $uploader->save($path, $_FILES['banner_image']['name']);

                    // Delete old image if exists
                    $oldImage = $model->getData('banner_image');
                    if (!empty($oldImage)) {
                        $oldImagePath = Mage::getBaseDir('media') . DS . $oldImage;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }

                    $data['banner_image'] = $uploader->getUploadedFileName();
                } elseif (isset($data['banner_image']['delete']) && $data['banner_image']['delete'] == 1) {
                    // Delete the old image
                    $oldImage = $model->getData('banner_image');
                    if (!empty($oldImage)) {
                        $oldImagePath = Mage::getBaseDir('media') . DS . $oldImage;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }

                    $data['banner_image'] = ''; // Empty the image field if delete checkbox is checked
                } else {
                    unset($data['banner_image']); // Unset the image data if no new image uploaded and not deleting existing one
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('banner_id' => $this->getRequest()->getParam('banner_id')));
                return;
            }

            // Set other data
            $model->setData($data);

            try {
                // Save the data
                $model->save();

                // Display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('banner')->__('The Banner has been saved.')
                );
                // Clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // Check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('banner_id' => $model->getId(), '_current' => true));
                    return;
                }
                // Go to grid
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    Mage::helper('banner')->__('An error occurred while saving the banner.')
                );
            }

            // Set form data
            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('banner_id' => $this->getRequest()->getParam('banner_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('banner_id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('banner/banner');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('banner')->__('The banner has been deleted.'));
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('banner_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banner')->__('Unable to find a banner to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }
    protected function _isAllowed()
    {
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'new':
                $aclResource = 'banner/banner/actions/new';
                break;
            case 'edit':
                $aclResource = 'banner/banner/actions/edit';
                break;
            case 'save':
                $aclResource = 'banner/banner/actions/save';
                break;
            case 'delete':
                $aclResource = 'banner/banner/actions/delete';
                break;
            default:
                $aclResource = 'banner/banner/actions/index';
                break;
        }
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }
    public function massDeleteAction()
    {
        $bannerIds = $this->getRequest()->getParam('banner_id');
        if (!is_array($bannerIds)) {
            $this->_getSession()->addError($this->__('Please select banner(s).'));
        } else {
            if (!empty($bannerIds)) {
                try {
                    foreach ($bannerIds as $bannerId) {
                        $banner = Mage::getSingleton('banner/banner')->load($bannerId);
                        // Mage::dispatchEvent('banner_controller_banner_delete', array('banner' => $banner));
                        $banner->delete();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been deleted.', count($bannerIds))
                    );
                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction()
    {
        $bannerIds = $this->getRequest()->getParam('banner_id');
        $status = $this->getRequest()->getParam('status');

        if (!is_array($bannerIds)) {
            $bannerIds = array($bannerIds);
        }

        try {
            foreach ($bannerIds as $bannerId) {
                $banner = Mage::getModel('banner/banner')->load($bannerId);
                // Check if the status is different than the one being set
                if ($banner->getStatus() != $status) {
                    $banner->setStatus($status)->save();
                }
            }
            // Use appropriate success message based on the status changed
            if ($status == 1) {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been enabled.', count($bannerIds))
                );
            } else {
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) have been disabled.', count($bannerIds))
                );
            }
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }

        $this->_redirect('*/*/index');
    }

}
