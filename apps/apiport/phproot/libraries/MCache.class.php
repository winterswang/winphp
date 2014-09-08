<?php
class MCache {
	
	private $handle;

	public function __construct($host='127.0.0.1', $port = 36000) {
		$this->handle = memcache_connect($host, $port);
	}

	public function get($key) {
		$data = memcache_get($this->handle, $key);
		return json_decode($data);
	}
	
	public function set($key, $obj, $expire=3600) {
		$data = json_encode($obj);
		memcache_set($this->handle, $key, $data, 0, $expire);
	}
}
