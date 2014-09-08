<?php

abstract class AuthProvider
{

    public $provider;
    public $config = NULL;
    public $params = null;
    public $authclient = null;
    public $store;

    function __construct($provider, $config, $params)
    {
        $this->provider = $provider;
        $this->config = $config;
        $this->params = $params;

        $session_id = isset($params['uid']) && $params['uid'] ? $this->session_id($params['uid']) : null;
        $this->store = new AuthStorage($session_id);

        $this->authclient = new AuthClient($config["client_id"], $config["client_secret"]);
        $this->authclient->api_base_url = $config["api_url"];
        $this->authclient->authorize_url = $config['authorize_url'];
        $this->authclient->token_url = $config['token_url'];
        $this->authclient->redirect_uri = $config['redirect_uri'];

        if ($this->get("access_token")) {
            $this->authclient->access_token = $this->get("access_token");
            $this->authclient->refresh_token = $this->get("refresh_token");
            $this->authclient->access_token_expires_in = $this->get("expires_in");
            $this->authclient->access_token_expires_at = $this->get("expires_at");
        }
    }

    abstract protected function login_url($params = array());

    abstract protected function login($code);

    function logout()
    {
        $this->store->clear();
    }

    function session_id($uid = null)
    {
        if (!empty($uid)) {
            //base_convert( md5( $uid.$provider ), 16, 10 );
            //crc32($uid.$provider)
            $hash = md5($uid . $this->provider . $this->config['client_id']);
            return substr($hash, 0, 16);
        }
        return null;
    }

    function newTokenSession($uid, $token)
    {
        $type = $this->provider;
        $access_token = $token['access_token'];
        $expires_in = isset($token['expires_in']) ? $token['expires_in'] : 0;
        $refresh_token = isset($token['refresh_token']) ? $token['refresh_token'] : '';

        $session_id = $this->session_id($uid);
        return $this->store->newSession($session_id, $uid, $type, $access_token, $expires_in, $refresh_token);
    }

    function refreshToken()
    {
        if (!$this->authclient->access_token) {
            return array();
        }

        if ($this->authclient->refresh_token && $this->authclient->access_token_expires_at) {

            if ($this->authclient->access_token_expires_at <= time()) {
                $response = $this->authclient->refreshToken(array("refresh_token" => $this->authclient->refresh_token));

                if (!isset($response->access_token) || !$response->access_token) {
                    throw new Exception("The Authorization Service has return an invalid response while requesting a new access token. " . (string) $response->error);
                }

                // set new access_token
                $this->authclient->access_token = $response->access_token;

                if (isset($response->refresh_token))
                    $this->authclient->refresh_token = $response->refresh_token;

                if (isset($response->expires_in)) {
                    $this->authclient->access_token_expires_in = $response->expires_in;
                    $this->authclient->access_token_expires_at = time() + $response->expires_in;
                }
            }

            $this->set("access_token", $this->authclient->access_token);
            $this->set("refresh_token", $this->authclient->refresh_token);
            $this->set("expires_in", $this->authclient->access_token_expires_in);
            $this->set("expires_at", $this->authclient->access_token_expires_at);
        }
    }

    public function token()
    {
        return array(
            'access_token'  => $this->get("access_token"),
            'refresh_token' => $this->get("refresh_token"),
            'expires_in'    => (int) $this->get("expires_in"),
            'expires_at'    => (int) $this->get("expires_at")
        );
    }

    function set_remote_ip($ip)
    {
        if (ip2long($ip) !== false) {
            $this->authclient->remote_ip = $ip;
            return true;
        } else {
            return false;
        }
    }

    public function get($key)
    {
        return $this->store->get($key);
    }

    public function set($key, $value = NULL)
    {
        $this->store->set($key, $value);
    }

}
