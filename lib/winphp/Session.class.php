<?php
class Session
{
	public $autoStart=true;

	public function __construct()
	{
		if($this->autoStart){
			@session_start();
		}
		register_shutdown_function(array($this,'close'));
	}

	public function close()
	{
		if(session_id()!=='')
			@session_write_close();
	}

	public function destroy()
	{
		if(session_id()!=='')
		{
			@session_unset();
			@session_destroy();
		}
	}

	public function getSessionID()
	{
		return session_id();
	}

	public function setSessionID($value)
	{
		session_id($value);
	}

	public function regenerateID($deleteOldSession=false)
	{
		session_regenerate_id($deleteOldSession);
	}

	public function getSessionName()
	{
		return session_name();
	}

	public function setSessionName($value)
	{
		session_name($value);
	}

	public function getSavePath()
	{
		return session_save_path();
	}

	public function setSavePath($value)
	{
		if(is_dir($value))
			session_save_path($value);
		else
			throw new Exception('Session.savePath "$value" is not a valid directory.');
	}

	public function getCookieParams()
	{
		return session_get_cookie_params();
	}

	public function setCookieParams($value)
	{
		$data=session_get_cookie_params();
		extract($data);
		extract($value);
		if(isset($httponly))
			session_set_cookie_params($lifetime,$path,$domain,$secure,$httponly);
		else
			session_set_cookie_params($lifetime,$path,$domain,$secure);
	}

	public function getCookieMode()
	{
		if(ini_get('session.use_cookies')==='0')
			return 'none';
		else if(ini_get('session.use_only_cookies')==='0')
			return 'allow';
		else
			return 'only';
	}

	public function setCookieMode($value)
	{
		if($value==='none')
		{
			ini_set('session.use_cookies','0');
			ini_set('session.use_only_cookies','0');
		}
		else if($value==='allow')
		{
			ini_set('session.use_cookies','1');
			ini_set('session.use_only_cookies','0');
		}
		else if($value==='only')
		{
			ini_set('session.use_cookies','1');
			ini_set('session.use_only_cookies','1');
		}
		else
			throw new Exception('Session.cookieMode can only be "none", "allow" or "only"');
	}

	public function getGCProbability()
	{
		return (int)ini_get('session.gc_probability');
	}

	public function setGCProbability($value)
	{
		$value=(int)$value;
		if($value>=0 && $value<=100)
		{
			ini_set('session.gc_probability',$value);
			ini_set('session.gc_divisor','100');
		}
		else
			throw new Exception('Session.gcProbability "$value" is invalid. It must be an integer between 0 and 100.');
	}

	public function getUseTransparentSessionID()
	{
		return ini_get('session.use_trans_sid')==1;
	}


	public function setUseTransparentSessionID($value)
	{
		ini_set('session.use_trans_sid',$value?'1':'0');
	}

	public function getTimeout()
	{
		return (int)ini_get('session.gc_maxlifetime');
	}

	public function setTimeout($value)
	{
		ini_set('session.gc_maxlifetime',$value);
	}

	public function get($key,$defaultValue=null)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : $defaultValue;
	}

	public function add($key,$value)
	{
		$_SESSION[$key]=$value;
	}

	public function remove($key)
	{
		if(isset($_SESSION[$key]))
		{
			$value=$_SESSION[$key];
			unset($_SESSION[$key]);
			return $value;
		}
		else
			return null;
	}

	public function clear()
	{
		foreach(array_keys($_SESSION) as $key)
			unset($_SESSION[$key]);
	}

}
