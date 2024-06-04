<?php
require_once ('../app/Mage.php'); //Path to Magento
Mage::app();
// echo "<pre>";

$observer = new Ccc_Outlook_Model_Observer();
$observer->storeEmails();