<?php

class Ccc_Filemanager_Model_Filemanager extends Varien_Data_Collection_Filesystem
{
    protected function _generateRow($filename)
    {
        $pathInfo = pathinfo($filename);
        
        $mainDir = array_keys($this->_targetDirs)[0];
        $mainDir = preg_quote($mainDir,"\\");
        
        $dirName = preg_replace("/$mainDir/", "", $pathInfo['dirname'], 1);
        $dirName = empty($dirName) ? "\\" : $dirName;

        $createdDate = date("Y-m-d H:i:s", filectime($filename));
        return array(
            'created_date' => $createdDate,
            'filename' => $pathInfo['filename'],
            'folderpath' => $dirName,
            'extension' => $pathInfo['extension'],
            'fullpath' => $filename,
            'main_directory' => array_keys($this->_targetDirs)[0],
            'basename' => $pathInfo['basename'],
        );
    }
    public function filterCallbackLike($field, $filterValue, $row)
    {
        $filterValueRegex = str_replace('%', '(.*?)', preg_quote($filterValue, '/'));
        $filterValueRegex = trim($filterValueRegex, "''");
        return (bool) preg_match("/^{$filterValueRegex}$/i", $row[$field]);
    }
}