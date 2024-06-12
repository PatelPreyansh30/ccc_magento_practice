<?php
class Ccc_Ftp_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getLocalDir()
    {
        return Mage::getBaseDir() . "\\var\\filezilla";
    }
}
