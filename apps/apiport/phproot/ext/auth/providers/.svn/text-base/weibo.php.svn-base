<?php

class Weibo extends AuthProvider
{

    public $format = "json";

    public function __construct($provider, $config, $params)
    {
        parent::__construct($provider, $config, $params);
    }

    function login_url($params = array())
    {
        return $this->authclient->authorizeUrl($params);
    }

    function login($code)
    {

        $this->logout();

        $resp = $this->authclient->authenticate($code);

        // check if authenticated
        if (!$this->authclient->authenticated()) {
            throw new Exception("Authentification failed! returned an invalid access token.", 5);
        }

        if (isset($resp->access_token)) {
            $this->authclient->access_token = $resp->access_token;
        }

        return $resp;
    }

    function getUserInfo($uid)
    {
        $res = $this->api("users/show", array('uid' => $uid));
        return $res;
    }

    function api($api, $apiParams = array(), $method = 'GET', $muile = false)
    {

        $this->refreshToken();

        $requestUrl = $this->authclient->api_base_url . "/" . $api . '.' . $this->format;
        $res = $this->authclient->api($requestUrl, $method, $apiParams, $muile);

        if ($this->authclient->http_code != 200) {
            $res = isset($res->error_code) ? array('code' => $res->error_code, 'msg'  => $res->error) : array('code' => $this->authclient->http_code, 'msg'  => $res);
        }

        if (is_object($res)) {
            $res = $this->object2Array($res);
        }

        return $res;
    }

    function object2Array($d)
    {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            return array_map(__FUNCTION__, $d);
        } else {
            return $d;
        }
    }

}