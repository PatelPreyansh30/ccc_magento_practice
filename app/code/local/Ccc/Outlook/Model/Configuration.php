<?php
class Ccc_Outlook_Model_Configuration extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('outlook/configuration');
    }
    public function fetchEmails()
    {
        if ($this->getRefreshToken() && $this->getId()) {
            $apiModel = Mage::getModel('outlook/token')->setConfigObj($this);

            $emails = $apiModel->getEmails();
            if (isset($emails['value']) && $emails['value'] != null) {
                foreach ($emails['value'] as $email) {
                    $emailModel = Mage::getModel('outlook/email')
                        ->setApiObj($apiModel)
                        ->setRowData($email);

                    if ($emailModel->getConfigId()) {
                        $emailModel->save();
                        if ($emailModel->getHasAttachment()) {
                            $emailModel->fetchAndSaveAttachments();
                        }
                        $emailModel->dispatchEmailEvent();
                    }
                }
            }
        }
    }
}