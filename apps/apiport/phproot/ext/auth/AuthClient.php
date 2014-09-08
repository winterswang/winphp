<?php

class AuthClient
{

    public $api_base_url = "";
    public $authorize_url = "";
    public $token_url = "";
    public $token_info_url = "";
    public $client_id = "";
    public $client_secret = "";
    public $redirect_uri = "";
    public $access_token = "";
    public $refresh_token = "";
    public $access_token_expires_in = "";
    public $access_token_expires_at = "";
    public $remote_ip = '';
    //--

    public $sign_token_name = "access_token";
    public $decode_json = true;
    public $curl_time_out = 30;
    public $curl_connect_time_out = 30;
    public $curl_header = array();
    public $curl_useragent = 'Sae T OAuth2 v0.1';
    public static $boundary = '';
    //--

    public $http_code = "";
    public $http_info = "";

    //--

    public function __construct($client_id = false, $client_secret = false, $redirect_uri = '')
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
    }

    public function authorizeUrl($extras = array())
    {
        $params = array(
            "client_id"     => $this->client_id,
            "redirect_uri"  => $this->redirect_uri,
            "response_type" => "code"
        );

        if (count($extras))
            foreach ($extras as $k => $v)
                $params[$k] = $v;

        return $this->authorize_url . "?" . http_build_query($params);
    }

    public function authenticate($code)
    {
        $params = array(
            "client_id"     => $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type"    => "authorization_code",
            "redirect_uri"  => $this->redirect_uri,
            "code"          => $code
        );

        $response = $this->post($this->token_url, $params);
        //$response = $this->parseRequestResult( $response );

        if (!$response || !isset($response->access_token)) {
            throw new Exception("The Authorization Service has return: " . $response->error);
        }

        if (isset($response->access_token))
            $this->access_token = $response->access_token;
        if (isset($response->refresh_token))
            $this->refresh_token = $response->refresh_token;
        if (isset($response->expires_in))
            $this->access_token_expires_in = $response->expires_in;

        // calculate when the access token expire
        $this->access_token_expires_at = time() + $response->expires_in;

        return $response;
    }

    public function authenticated()
    {
        if ($this->access_token) {
            if ($this->token_info_url && $this->refresh_token) {
                // check if this access token has expired, 
                $tokeninfo = $this->tokenInfo($this->access_token);

                // if yes, access_token has expired, then ask for a new one
                if ($tokeninfo && isset($tokeninfo->error)) {
                    $response = $this->refreshToken($this->refresh_token);

                    // if wrong response
                    if (!isset($response->access_token) || !$response->access_token) {
                        throw new Exception("The Authorization Service has return an invalid response while requesting a new access token. given up!");
                    }

                    // set new access_token
                    $this->access_token = $response->access_token;
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Format and sign an oauth for provider api 
     */
    public function api($url, $method = "GET", $parameters = array(), $multi = false)
    {
        if (strrpos($url, 'http://') !== 0 && strrpos($url, 'https://') !== 0) {
            $url = $this->api_base_url . $url;
        }

        $parameters[$this->sign_token_name] = $this->access_token;
        $response = null;

        switch ($method) {
            case 'GET' :
                $url = $url . '?' . http_build_query($parameters);
                $response = $this->request($url, "GET");
                break;
            default :
                $headers = array();
                if (!$multi && (is_array($parameters) || is_object($parameters))) {
                    $body = http_build_query($parameters);
                } else {
                    $body = $this->build_http_query_multi($parameters);
                    $headers[] = "Content-Type: multipart/form-data; boundary=" . self::$boundary;
                }
                $response = $this->request($url, "POST", $body, $headers);
                break;
        }

        if ($response && $this->decode_json) {
            $response = json_decode($response);
        }

        return $response;
    }

    /**
     * GET wrappwer for provider apis request
     */
    function get($url, $parameters = array())
    {
        return $this->api($url, 'GET', $parameters);
    }

    /**
     * POST wreapper for provider apis request
     */
    function post($url, $parameters = array(), $multi = false)
    {
        return $this->api($url, 'POST', $parameters, $multi);
    }

    // -- tokens

    public function tokenInfo($accesstoken)
    {
        $params['access_token'] = $this->access_token;
        return $this->get($this->token_info_url, $params);
        //return $this->parseRequestResult( $response );
    }

    public function refreshToken($parameters = array())
    {
        $params = array(
            "client_id"     => $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type"    => "refresh_token"
        );

        foreach ($parameters as $k => $v) {
            $params[$k] = $v;
        }

        return $this->post($this->token_url, $params);
        //return $this->parseRequestResult( $response );
    }

    private function request($url, $method = "GET", $params = NULL, $headers = array())
    {
        $this->http_info = array();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_time_out);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->curl_useragent);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->curl_connect_time_out);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");

        if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == "https") {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        curl_setopt($ch, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, TRUE);
                if (!empty($params)) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                }
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if (!empty($params)) {
                    $url = "{$url}?{$params}";
                }
        }

        if (isset($this->access_token) && $this->access_token)
            $headers[] = "Authorization: OAuth2 " . $this->access_token;

        if (!empty($this->remote_ip)) {
            if (defined('SAE_ACCESSKEY')) {
                $headers[] = "SaeRemoteIP: " . $this->remote_ip;
            } else {
                $headers[] = "API-RemoteIP: " . $this->remote_ip;
            }
        } else {
            if (!defined('SAE_ACCESSKEY')) {
                $headers[] = "API-RemoteIP: " . $_SERVER['REMOTE_ADDR'];
            }
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE);

        $response = curl_exec($ch);

        $this->http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->http_info = array_merge($this->http_info, curl_getinfo($ch));

        curl_close($ch);

        return $response;
    }

    function getHeader($ch, $header)
    {
        $i = strpos($header, ':');
        if (!empty($i)) {
            $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
            $value = trim(substr($header, $i + 2));
        }
        return strlen($header);
    }

    public function build_http_query_multi($params)
    {
        if (!$params)
            return '';

        uksort($params, 'strcmp');

        $pairs = array();

        self::$boundary = $boundary = uniqid('------------------');
        $MPboundary = '--' . $boundary;
        $endMPboundary = $MPboundary . '--';
        $multipartbody = '';

        foreach ($params as $parameter => $value) {

            if (!empty($value) && $value{0} == '@') {
                $url = ltrim($value, '@');
                $content = @file_get_contents($url);
                $array = explode('?', basename($url));
                $filename = $array[0];

                $multipartbody .= $MPboundary . "\r\n";
                $multipartbody .= 'Content-Disposition: form-data; name="' . $parameter . '"; filename="' . $filename . '"' . "\r\n";
                $multipartbody .= "Content-Type: image/jpeg\r\n\r\n";
                $multipartbody .= $content . "\r\n";
            } else {
                $multipartbody .= $MPboundary . "\r\n";
                $multipartbody .= 'content-disposition: form-data; name="' . $parameter . "\"\r\n\r\n";
                $multipartbody .= $value . "\r\n";
            }
        }

        $multipartbody .= $endMPboundary;
        return $multipartbody;
    }

    private function parseRequestResult($result)
    {
        if (json_decode($result))
            return json_decode($result);

        parse_str($result, $ouput);

        $result = new StdClass();

        foreach ($ouput as $k => $v)
            $result->$k = $v;

        return $result;
    }

}