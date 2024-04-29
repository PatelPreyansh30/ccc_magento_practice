<?php
require_once Mage::getModuleDir('controllers', 'Mage_Adminhtml') . '/Sales/Order/CreateController.php';

class Ccc_Catalog_Sales_Order_CreateController extends Mage_Adminhtml_Sales_Order_CreateController
{
    public function uploadAddressProofAction()
    {
        $response = ['success' => false, 'error' => 'No file uploaded'];
        if (isset($_FILES['address_proof']['name']) && $_FILES['address_proof']['name'] != '') {
            try {
                $uploader = new Varien_File_Uploader('address_proof');
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $uploader->addValidateCallback('size', $this, 'validateMaxSize');
                $path = Mage::getBaseDir('media') . DS . 'address_proof' . DS;
                $result = $uploader->save($path);

                if ($result) {
                    $filePath = 'address_proof/' . $result['file'];
                    $response = ['success' => true, 'path' => $filePath];
                }
            } catch (Exception $e) {
                $response = ['success' => false, 'error' => $e->getMessage()];
            }
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
    }
}