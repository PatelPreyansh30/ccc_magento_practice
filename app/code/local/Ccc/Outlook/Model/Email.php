<?php
class Ccc_Outlook_Model_Email extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('outlook/email');
    }
    public function setEmails($email, $configId, Ccc_Outlook_Model_Token $apiModel)
    {
        if (isset($email['sender']['emailAddress']['address'])) {
            $emailAddress = $email['sender']['emailAddress']['address'];
            if (!strpos($emailAddress, 'microsoft')) {
                $this->setConfigId($configId);
                $this->setOutlookEmailId($email['id']);
                $this->setFrom($emailAddress);
                $this->setSubject($email['subject']);
                $this->setBody($email['bodyPreview']);
                $this->setHasAttachment($email['hasAttachments']);
                $this->setReceivedDate($email['receivedDateTime']);
                $this->save();
            }
        }
        print_r($apiModel);
    }
}