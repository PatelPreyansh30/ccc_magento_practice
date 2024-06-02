<?php
class Ccc_Outlook_OutlookController extends Mage_Core_Controller_Front_Action
{
    public function getCodeAction()
    {
        $code = $this->getRequest()->getParam('code');
        $id = $this->getRequest()->getParam('entity_id');

        if ($id && $code) {
            $configModel = Mage::getModel('outlook/configuration')->load($id);
            $model = Mage::getModel('outlook/token')
                ->setClientId($configModel->getClientId())
                ->setClientSecret($configModel->getClientSecret())
                ->setCode($code)
                ->setEntityId($id)
                ->getAccessToken();

            if($model->getRefreshToken()){
                $configModel->setRefreshToken($model->getRefreshToken())
                ->setLoggedIn(1)
                ->save();
                echo "Successfully logged in";
            }
        }
    }
}
