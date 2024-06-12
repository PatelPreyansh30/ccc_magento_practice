<?php

class Ccc_Ftp_Model_Observer
{
    public function transferFile()
    {
        $configCollection = Mage::getModel('ccc_ftp/configuration')
            ->getCollection();

        foreach ($configCollection as $configData) {
            $configData->fetchFiles();
        }
    }
}