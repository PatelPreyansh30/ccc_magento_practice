<?php

class Ccc_Test_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        echo get_class(Mage::getModel('Ccc_test/abc'));
    }
}
