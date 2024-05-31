<?php
class Ccc_Outlook_Model_Token
{
    protected $_clientId = '39dad5f0-1478-4c32-83b1-13103b97e02b';
    protected $_clientSecret = '3CA8Q~edasGfAPrcjOT2RoCP~455kT5VqRj-BaI3';
    protected $_code = '';
    private $tenantId = 'common';
    private $scope = 'offline_access user.read mail.read';
    private $state = '12345';
    private $responseMode = 'query';
    private $responseType = 'code';
    // protected $redirectUri = ;
    private $_grantType = 'authorization_code';

    public function getClientId()
    {
        return $this->_clientId;
    }
    public function setClientId($clientId)
    {
        $this->_clientId = $clientId;
        return $this;
    }
    public function getClientSecret()
    {
        return $this->_clientSecret;
    }
    public function setClientSecret($clientSecret)
    {
        $this->_clientSecret = $clientSecret;
        return $this;
    }
    public function getRedirectUri(){
        return "http://localhost/magento/outlook/outlook/getCode";
    }
    public function getAccessToken()
    {
        $url = 'https://login.microsoftonline.com/' . $this->tenantId . '/oauth2/v2.0/token';
        $data = [
            'client_id' => $this->getClientId(),
            'scope' => 'Mail.Read Mail.ReadBasic',
            'code' => $this->_code,
            'redirect_uri' => $this->getRedirectUri(),
            'grant_type' => $this->_grantType,
            'client_secret' => $this->getClientSecret(),
        ];

        $options = [
            'http' => [
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            throw new Exception('Error obtaining access token');
        }

        $response = json_decode($result, true);
        return $response['access_token'];
    }
    public function getAccessCode()
    {
        $url = 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize?';
        $url .= "client_id={$this->getClientId()}";
        $url .= "&scope=offline_access user.read mail.read";
        $url .= "&response_mode=query";
        $url .= "&response_type=code";
        $url .= "&redirect_uri={$this->getRedirectUri()}";
        $url .= "&state=12345";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Error fetching access token: ' . curl_error($ch));
        }
        curl_close($ch);

        $result = json_decode($response, true);
        return $result;
    }
    public function getEmails()
    {
        $accessToken = $this->getAccessToken();
        $url = 'https://graph.microsoft.com/v1.0/users/' . $this->username . '/messages';
        $url = 'https://graph.microsoft.com/v1.0/me/messages';

        $options = [
            'http' => [
                'header' => "Authorization: Bearer " . $accessToken . "\r\n" .
                    "Content-Type: application/json\r\n",
                'method' => 'GET',
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        var_dump($result);
        if ($result === FALSE) {
            throw new Exception('Error fetching emails');
        }

        $emails = json_decode($result, true);
        return $emails;
    }
}
