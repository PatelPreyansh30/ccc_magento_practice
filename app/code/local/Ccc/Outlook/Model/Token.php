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
            $this->setAccessToken($response['access_token']);
            $this->setRefreshToken($response['refresh_token']);
        }
        curl_close($ch);

        return $this;
    }
    public function getAccessTokenFromRefreshToken()
    {
        $url = 'https://login.microsoftonline.com/' . $this->getTenant() . '/oauth2/v2.0/token';
        $data = [
            'client_id' => $this->getClientId(),
            'scope' => $this->getRefreshScope(),
            'refresh_token' => $this->getRefreshToken(),
            'grant_type' => $this->getRefreshGrantType(),
            'client_secret' => $this->getClientSecret(),
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
        } elseif (isset($response['access_token'])) {
            $this->setAccessToken($response['access_token']);
        }
        curl_close($ch);

        return $this;
    }
    public function getEmails()
    {
        $url = 'https://graph.microsoft.com/v1.0/me/messages?$select=id,receivedDateTime,hasAttachments,bodyPreview,sender,subject';

        // if($this->getLastReadedDate()){
        //     $url .= '&filter=receivedDateTime gt 2024-06-01';
        // }

        $headers = [
            'Authorization: Bearer ' . $this->getData('access_token'),
            'Prefer: outlook.body-content-type=text',
            'Accept: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $response = json_decode($response, true);
        if (isset($response['error'])) {
            print_r($response['error_description']);
        }
        curl_close($ch);
        return $response;
    }
    public function getEmailAttachments($outlookEmailId)
    {
        $url = 'https://graph.microsoft.com/v1.0/me/messages/' . $outlookEmailId . '/attachments';

        $headers = [
            'Authorization: Bearer ' . $this->getData('access_token'),
            'Accept: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $response = json_decode($response, true);
        if (isset($response['error'])) {
            print_r($response['error_description']);
        }
        curl_close($ch);
        return $response;
    }
}
