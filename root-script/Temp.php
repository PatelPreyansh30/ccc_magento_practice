<?php
require_once ('../app/Mage.php'); //Path to Magento
Mage::app();
echo "<pre>";

$observer = new Ccc_Ftp_Model_Observer();
$observer->transferFile();