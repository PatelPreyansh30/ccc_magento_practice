<?php
class Ccc_Outlook_OutlookController extends Mage_Core_Controller_Front_Action
{
    public function getCodeAction()
    {
        echo "<pre>";
        // echo 123;
        var_dump($this->getRequest()->getParams());
        // die;
    }
}
