<?php
class Ccc_Ftp_Model_Ftp extends Varien_Io_Ftp
{
    protected $_configModel;
    protected $_complete = 'Completed';
    protected $_files = [];
    public function setConfigModel(Ccc_Ftp_Model_Configuration $config)
    {
        $this->_configModel = $config;
        return $this;
    }
    public function fetchAndMoveFile()
    {
        $argument = [
            'host' => $this->_configModel->getHost(),
            'port' => $this->_configModel->getPort(),
            'user' => $this->_configModel->getUserName(),
            'password' => $this->_configModel->getPassword(),
        ];
        $this->open($argument);
        $this->recursiveLs($this->pwd());
        $this->transferFiles();
        $this->close();
        return $this->_files;
    }
    public function recursiveLs($dir)
    {
        $files = ftp_mlsd($this->_conn, $dir);
        foreach ($files as $file) {
            if (isset($file['type'])) {
                if ($file['type'] == 'dir') {
                    if ($file['name'] == $this->_complete && $this->pwd() == $dir) {
                        continue;
                    } else {
                        $this->recursiveLs($dir . '\\' . $file['name']);
                    }
                } elseif ($file['type'] == 'file') {
                    $this->_files[] = [
                        'name' => $file['name'],
                        'path' => substr($dir, 1),
                        'fullpath' => substr($dir, 1) . DS . $file['name'],
                    ];
                }
            }
        }
    }
    public function transferFiles()
    {
        if (!empty($this->_files)) {
            $localDir = Mage::helper('ccc_ftp')->getLocalDir();
            foreach ($this->_files as $key => $file) {
                $fileInfo = pathinfo($file['fullpath']);
                $fileDate = ftp_mdtm($this->_conn, $file['fullpath']);

                $newName = $file['path'] . DS . $fileInfo['filename'] . '_' . $fileDate . "." . $fileInfo['extension'];

                if (!file_exists($localDir . $file['path'])) {
                    mkdir($localDir . $file['path'], 0777, true);
                }
                $result = $this->read($file['fullpath'], $localDir . $newName);
                if ($result) {
                    if (!file_exists($this->_complete . $file['path'])) {
                        ftp_mkdir($this->_conn, $this->_complete . $file['path']);
                    }
                    $status = $this->mv($file['fullpath'], $this->_complete . DS . $newName);

                    $this->_files[$key]['newname'] = $fileInfo['filename'] . '_' . $fileDate . "." . $fileInfo['extension'];
                    $this->_files[$key]['date'] =  $fileDate;
                    // if ($status) {
                    //     $files = ftp_nlist($this->_conn, $file['path']);
                    //     print_r($files);
                    //     if (empty($files)) {
                    //         ftp_rmdir($this->_conn, $file['path']);
                    //     }
                    // }
                }
            }
        }
    }
}