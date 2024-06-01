<?php
class Ccc_Outlook_Model_Token extends Mage_Core_Model_Abstract
{
    public function __construct()
    {
        $this->setData('token_scope', 'Mail.Read Mail.ReadBasic');
        $this->setData('refresh_scope', 'User.Read Mail.Read');
        $this->setData('redirect_uri', Mage::getBaseUrl() . 'outlook/outlook/getCode');
        $this->setData('token_grant_type', 'authorization_code');
        $this->setData('refresh_grant_type', 'refresh_token');
        $this->setData('tenant', 'common');
    }
    public function getAccessToken()
    {
        $url = 'https://login.microsoftonline.com/' . $this->getTenant() . '/oauth2/v2.0/token';
        $data = [
            'client_id' => $this->getClientId(),
            'code' => $this->getCode(),
            'client_secret' => $this->getClientSecret(),
            'scope' => $this->getTokenScope(),
            'redirect_uri' => $this->getRedirectUri() . '?entity_id=' . $this->getEntityId(),
            'grant_type' => $this->getTokenGrantType(),
        ];
        $headers = [
            'Content-Type: application/x-www-form-urlencoded'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $response = json_decode($response, true);
        if (isset($response['error'])) {
            print_r($response['error_description']);
        } else {
            curl_close($ch);
            $this->setAccessToken($response['access_token']);
            $this->setRefreshToken($response['refresh_token']);
        }

        return $this;
    }
    public function getEmails()
    {
        echo "get email";
        $url = 'https://graph.microsoft.com/v1.0/me/messages';

        $headers = [
            'Authorization: Bearer ' . $this->_accessToken,
            'Prefer: outlook.body-content-type=text',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Error while fetching emails: ' . curl_error($ch));
        }
        curl_close($ch);

        $result = json_decode($response, true);
        var_dump($result);
        return $this;
    }
}
