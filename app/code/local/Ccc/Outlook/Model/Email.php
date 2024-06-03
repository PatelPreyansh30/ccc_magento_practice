<?php
class Ccc_Outlook_Model_Email extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('outlook/email');
    }
    public function setRowData($email)
    {
        if (isset($email['sender']['emailAddress']['address'])) {
            $emailAddress = $email['sender']['emailAddress']['address'];
            if (!strpos($emailAddress, 'microsoft')) {
                $this->setConfigId($this->getApiObj()->getConfigObj()->getId());
                $this->setOutlookEmailId($email['id']);
                $this->setFrom($emailAddress);
                $this->setSubject($email['subject']);
                $this->setBody($email['bodyPreview']);
                $this->setHasAttachment($email['hasAttachments']);
                $this->setReceivedDate($email['receivedDateTime']);
            }
        }
        return $this;
    }
    public function fetchAndSaveAttachments()
    {
        $attachments = $this->getApiObj()
            ->getEmailAttachments($this->getOutlookEmailId());

        if (isset($attachments['value']) && $attachments['value'] != null) {
            foreach ($attachments['value'] as $attachment) {
                Mage::getModel('outlook/attachment')
                ->setEmailObj($this)
                ->setRowData($attachment)
                ->save();
            }
        }
    }
}