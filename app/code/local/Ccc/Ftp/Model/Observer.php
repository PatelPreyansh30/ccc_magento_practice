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
    public function storeParts()
    {
        $fileModel = Mage::getModel('ccc_ftp/files')
            ->load(15);
        $basePath = Mage::helper('ccc_ftp')->getLocalDir();
        $mapping = Mage::helper('ccc_ftp')->xmlMapping();

        $config = new Varien_Simplexml_Config();
        $config->loadFile($basePath . $fileModel->getPath() . DS . $fileModel->getFileName());

        $data = [];
        $partNumberArray = [];
        foreach ($config->getNode('items')->children() as $item) {
            $row = [];
            $rowKey = '';
            foreach ($mapping as $key => $map) {
                $map = explode(':', $map);
                $path = str_replace('.', '/', $map[0]);
                $attribute = $map[1];

                if ($item->descend($path)) {
                    $value = (string) $item->descend($path)->attributes()->$attribute;
                    if ($key == 'part_number') {
                        $rowKey = $value;
                        $partNumberArray[] = $value;
                    }
                    $row[$key] = $value;
                }
            }
            $data[$rowKey] = $row;
        }

        Mage::getModel('ccc_ftp/master')
        ->setXmlData($data)
        ->setPartNumberArray($partNumberArray)
        ->saveMaster();
    }
}
