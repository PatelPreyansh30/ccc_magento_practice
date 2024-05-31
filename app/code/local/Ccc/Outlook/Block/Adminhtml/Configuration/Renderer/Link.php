<?php

class Ccc_Outlook_Block_Adminhtml_Configuration_Renderer_Link extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $url = 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize?';
        $url .= "client_id={$element->getClientId()}";
        $url .= "&entity_id={$element->getEntityId()}";
        $url .= "&scope=offline_access user.read mail.read";
        $url .= "&response_mode=query";
        $url .= "&response_type=code";
        $url .= "&redirect_uri=http://localhost/magento/outlook/outlook/getCode";
        $url .= "&state=12345";

        $html = '<tr>';
        $html .= '<td class="label">';
        $html .= '<a href="' . $url . '" target="_blank">Login</a>';
        $html .= '</td>';
        $html .= '<td class="value"></td>';
        $html .= '</tr>';
        return $html;
    }
}
