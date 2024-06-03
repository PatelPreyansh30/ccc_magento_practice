<?php
class Ccc_Outlook_Model_Attachment extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('outlook/attachment');
    }
    public function setRowData($attachent)
    {
        $fileName = $attachent['name'];
        $fileData = base64_decode($attachent['contentBytes']);
        $path = Mage::getBaseDir('var') . DS . 'email_attachments' . DS;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $filePath = $this->_getUniqueFilePath($path, $fileName, $fileData);

        $this->setPath($filePath);
        $this->setOutlookAttachmentId($attachent['id']);
        $this->setEmailId($this->getEmailObj()->getId());
        $this->setOriginalName($attachent['name']);
        return $this;
    }
    protected function _getUniqueFilePath($path, $fileName, $fileData)
    {
        $filePath = $path . $fileName;
        $fileInfo = pathinfo($filePath);
        $baseName = $fileInfo['filename'];
        $extension = isset($fileInfo['extension']) ? '.' . $fileInfo['extension'] : '';
        $counter = 1;

        while (file_exists($filePath)) {
            $filePath = $path . $baseName . '_' . $counter . $extension;
            $counter++;
        }

        file_put_contents($filePath, $fileData);
        $fileInfo = pathinfo($filePath);
        $baseName = $fileInfo['filename'];
        return $baseName . $extension;
    }
}