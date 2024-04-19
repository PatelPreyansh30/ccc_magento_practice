<?php
require_once Mage::getModuleDir('controllers', 'Mage_Checkout') . '/OnepageController.php';
class Ccc_Catalog_OnepageController extends Mage_Checkout_OnepageController
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

    public function saveBillingAction()
    {
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('billing', array());
            $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);

            $billingAddress = $this->getOnepage()->getQuote()->getBillingAddress();

            if (isset($data['address_proof'])) {
                $billingAddress->setData('address_proof', $data['address_proof']);
            }

            $result = $this->getOnepage()->saveBilling($data, $customerAddressId);

            if (!isset($result['error'])) {
                if ($this->getOnepage()->getQuote()->isVirtual()) {
                    $result['goto_section'] = 'payment';
                    $result['update_section'] = array(
                        'name' => 'payment-method',
                        'html' => $this->_getPaymentMethodsHtml()
                    );
                } elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
                    $result['goto_section'] = 'shipping_method';
                    $result['update_section'] = array(
                        'name' => 'shipping-method',
                        'html' => $this->_getShippingMethodsHtml()
                    );

                    $result['allow_sections'] = array('shipping');
                    $result['duplicateBillingInfo'] = 'true';
                } else {
                    $result['goto_section'] = 'shipping';
                }
            }
            $this->_prepareDataJSON($result);
        }
    }
}
