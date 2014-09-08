<?php
include(dirname(__FILE__).DIRECTORY_SEPARATOR.'AuthProvider.php');
include(dirname(__FILE__).DIRECTORY_SEPARATOR.'AuthClient.php');

class AuthExt
{

    public $provider = NULL;
    public $config = NULL;
    public $adapter = NULL;

    public function setup($provider = '', $config = array(), $params = array())
    {

        $this->provider = $provider;
        $this->config = $config;

        $providerConfig = $this->getProviderConfig();

        if (empty($providerConfig)) {
            throw new CException("Unknown Provider, check your configuration file.");
        }
        
        $className = ucfirst($provider);
        
        include(dirname(__FILE__).DIRECTORY_SEPARATOR.'providers'.DIRECTORY_SEPARATOR.$className.'.php');

        if (!class_exists($className)) {
            throw new Exception("Unable to load the Provider class '" . $className . "'");
        }

        $this->adapter = new $className($provider, $providerConfig, $params);
        return $this->adapter;
    }

    public function getProviderConfig()
    {
        if (isset($this->config[$this->provider])) {
            return $this->config[$this->provider];
        }

        return array();
    }

}