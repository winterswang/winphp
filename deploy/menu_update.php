<?php
function raw_post($url, $data) {

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://url/url/url");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "body goes here");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
	$result = curl_exec($ch);
	var_dump($result);
}

function raw_get($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
	$result = curl_exec($ch);
	return $result;
}

function get_access_token() {
	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxadcb2b0d4be9cb19&secret=172e1b29a273156cc905da8394145142";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	$data = curl_exec($ch);
	$ret = json_decode($data);
	curl_close($ch);
	if (isset($ret ->errcode)) {
		echo "get access token error";
		die;
	}
	return $ret->acess_token;
}

$token = get_access_token();
$url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=$token";
$json = raw_get($url);

var_dump($json);

?>
