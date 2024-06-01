<?php
class Ccc_Outlook_Model_Configuration extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('outlook/configuration');
    }
    public function getEmails()
    {
        if ($this->getRefreshToken() && $this->getId()) {
            $apiModel = Mage::getModel('outlook/token')
                ->setRefreshToken($this->getRefreshToken())
                ->setClientId($this->getClientId())
                ->setClientSecret($this->getClientSecret())
                ->getAccessTokenFromRefreshToken();

            $emails = $apiModel->getEmails();
            if (isset($emails['value']) && $emails['value'] != null) {
                foreach ($emails['value'] as $email) {
                    Mage::getModel('outlook/email')
                        ->setEmails($email, $this->getId(), $apiModel);
                }
            }
        }
    }
}