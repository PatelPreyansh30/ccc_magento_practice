<?php
class Ccc_Ftp_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getLocalDir()
    {
        return Mage::getBaseDir() . "\\var\\filezilla";
    }
    public function xmlMapping()
    {
        return [
            'part_number' => 'itemIdentification.itemIdentifier:itemNumber',
            'height' => 'itemIdentification.itemCharacteristics.itemDimensions.height:value',
            'depth' => 'itemIdentification.itemCharacteristics.itemDimensions.depth:value',
            'length' => 'itemIdentification.itemCharacteristics.itemDimensions.length:value',
            'weight' => 'itemIdentification.itemCharacteristics.itemDimensions.weight:value',
            // 'image' => 'image:name',
        ];
    }
}
