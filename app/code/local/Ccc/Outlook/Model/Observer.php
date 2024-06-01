<?php

class Ccc_Outlook_Model_Observer
{
    public function storeEmails()
    {
        $configCollection = Mage::getModel('outlook/configuration')
        ->getCollection()
        ->addFieldToFilter('is_active',1)
        ->addFieldToFilter('logged_in',1);

        foreach($configCollection as $configData){
            $configData->getEmails();
        }
    }
}