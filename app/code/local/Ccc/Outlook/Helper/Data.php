<?php
class Ccc_Outlook_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getPath()
    {
        $path = Mage::getBaseDir('var') . DS . 'email_attachments' . DS;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        return $path;
    }
}
