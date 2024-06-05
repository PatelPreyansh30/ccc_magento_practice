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
    public function dispatchEmailEvent()
    {
        $eventCollection = Mage::getModel('outlook/event')
            ->getCollection()
            ->addFieldToFilter('config_id', $this->getConfigId());

        $groupCollection = [];

        foreach ($eventCollection as $event) {
            $groupCollection[$event->getGroupId()][] = $event;
        }

        foreach ($groupCollection as $group) {
            $hasDispatchEvent = true;
            foreach ($group as $row) {
                $comparizonValue = null;
                $rowName = $row->getName();
                $rowOperator = $row->getOperator();
                $rowValue = $row->getValue();

                if ($rowName == 'from') {
                    $comparizonValue = $this->getFrom();
                } elseif ($rowName == 'subject') {
                    $comparizonValue = $this->getSubject();
                }

                if ($rowOperator == '%like%') {
                    if (strpos($comparizonValue, $rowValue) === false) {
                        $hasDispatchEvent = false;
                        break;
                    }
                } elseif ($rowOperator == 'like' || $rowOperator == '==') {
                    if (strcmp($comparizonValue, $rowValue) !== 0) {
                        $hasDispatchEvent = false;
                        break;
                    }
                }
            }
            if ($hasDispatchEvent) {
                echo $row->getEventName();
                Mage::dispatchEvent($row->getEventName(), ['email' => $this]);
            }
        }
    }
    protected function _afterSave()
    {
        if ($this->getReceivedDate() && $this->getId()) {
            $this->getApiObj()
                ->getConfigObj()
                ->setLastReadedDate($this->getReceivedDate())
                ->save();
        }
        return $this;
    }
}