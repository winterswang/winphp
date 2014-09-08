<?php
return array(
    
    'db'=>array(
        'dns' => 'mysql:host=192.168.1.99;dbname=house_spider',
        'username' => 'ikuaizu',
        'password' => 'ikuaizu@205'
    ),
    
    'setting' => array(
        'attach_path' => ROOT_STATIC_PATH.'/data/attachment',
        //'attach_url' => 'http://test.api.ikuaizu.com/data/attachment'
    ),
    
    'auth' => array(
        'weibo' => array(
            'client_id' => '3432276773',
            'client_secret' => '9c8d29801c157c3201549dc69f556432',
            'api_url'		=> 'https://api.weibo.com/2',
            'authorize_url' => 'https://api.weibo.com/oauth2/authorize',
            'logout_url'    => 'https://api.weibo.com/2/account/end_session',
            'token_url'     => 'https://api.weibo.com/oauth2/access_token',
            'redirect_uri'	=> 'http://dev.ikuaizu.com/auth/weibo/login'
        )
    )
);