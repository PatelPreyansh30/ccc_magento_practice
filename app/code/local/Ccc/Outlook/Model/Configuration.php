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
                        $this->_dispatchEvent($emailModel);
                    }
                }
            }
        }
    }
    private function _dispatchEvent(Ccc_Outlook_Model_Email $emailModel)
    {
        $eventCollection = Mage::getModel('outlook/event')
            ->getCollection()
            ->addFieldToFilter('config_id', $emailModel->getConfigId());

        $groupCollection = [];

        foreach ($eventCollection as $event) {
            if (!isset($groupCollection[$event->getGroupId()])) {
                $groupCollection[$event->getGroupId()][] = $event;
            } else {
                $groupCollection[$event->getGroupId()][] = $event;
            }
        }

        foreach ($groupCollection as $group) {
            $hasDispatchEvent = true;
            foreach ($group as $row) {
                $comparizonValue = null;
                $rowName = $row->getName();
                $rowOperator = $row->getOperator();
                $rowValue = $row->getValue();

                if ($rowName == 'from') {
                    $comparizonValue = $emailModel->getFrom();
                } elseif ($rowName == 'subject') {
                    $comparizonValue = $emailModel->getSubject();
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
                Mage::dispatchEvent($row->getEventName(), ['email' => $emailModel]);
            }
        }
    }
}