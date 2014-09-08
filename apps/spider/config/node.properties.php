<?php
return array(
    'my5i5j' =>array(
        'host' =>'http://bj.5i5j.com',
        'page_rule' =>'{host}/exchange/{page}/',
        'page_prefix' =>'n',
        'href_rule' => '/exchange/{d}',
        'charset' => 'utf-8',
        'parser' => 'my5i5j',
        'sleep' => 3
        ),
    'my5i5j_district' =>array(
        'host' => 'http://bj.5i5j.com',
        'page_rule' => '{host}/community/{page}/',
        'page_prefix' => 'n',
        'href_rule' => '/community/{d}',
        'charset' => 'utf-8',
        'parser' => 'my5i5j_district',
        'sleep' => 2
        ), 
    'my5i5j_agent' =>array(
        'host' => 'http://bj.5i5j.com',
        'page_rule' => '{host}/broker/{page}/',
        'page_prefix' => 'n',
        'href_rule' => '/broker/{d}',
        'charset' => 'utf-8',
        'parser' => 'my5i5j_agent',
        'sleep' => 2
        ),    
    'soufun' =>array(
        'host' =>'http://esf.soufun.com',
        'page_rule' =>'{host}/house/{page}/',
        'page_prefix' =>'i3',
        'href_rule' =>'/chushou/{*}.htm',
        'charset' => 'utf-8',
        'parser' => 'soufun',
        'sleep' => 2 
        ),
    'homelink_new' =>array(
        'host' => 'http://beijing.homelink.com.cn',
        'page_rule' => '{host}/ershoufang/{page}/',
        'page_prefix' => 'tt1pg',
        'href_rule' => '/ershoufang/{*}.shtml',
        'charset' => 'utf-8',
        'parser' => 'homelink',
        'sleep' => 2
        ),
	'homelink'=>array(
		'host' => 'http://beijing.homelink.com.cn',
		'page_rule' => '{host}/ershoufang/{page}/',
		'page_prefix' => 'pg',
		'href_rule' => '/ershoufang/{*}.shtml',
		'charset' => 'utf-8',
		'parser' => 'homelink',
		'sleep' => 2
	),
    'homelink_agent' =>array(
        'host' => 'http://beijing.homelink.com.cn',
        'page_rule' => '{host}/jingjiren/{page}/',
        'page_prefix' => 'pg',
        'href_rule' => 'http://{*}.beijing.homelink.com.cn',
        'charset' => 'utf-8',
        'parser' => 'homelink_agent',
        'sleep' => 2
        ),
    'homelink_xuequ' =>array(
        'host' => 'http://beijing.homelink.com.cn',
        'page_rule' => '{host}/school/list/{page}/',
        'page_prefix' => 'pg',
        'href_rule' => '/school/f{*}.shtml',
        'charset' => 'utf-8',
        'parser' => 'homelink_xuequ',
        'sleep' => 2
        ),
    'homelink_xuequ_district' =>array(
        'charset' => 'utf-8',
        'parser' => 'homelink_xuequ',
        ),
    'homelink_district' => array(
        'host' => 'http://beijing.homelink.com.cn',
        'page_rule' => '{host}/xiaoqu/{page}/',
        'page_prefix' => 'pg',
        'href_rule' => '/c-/',
        'charset' => 'utf-8',
        'parser' => 'homelink_district',
        'sleep' => 2
        ),
	
);