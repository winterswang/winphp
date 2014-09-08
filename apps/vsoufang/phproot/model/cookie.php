<?php
/**
* @author FeiYan
* @copyright FeiYan.Info
* @name Cookie通用类
*/

class cookie{

	private $cookieName; //cookie名称

	private $cookieValue; //cookie值

	private $cookieExpire; //cookie过期时间

	function __construct()
	{
	//构造函数
		if(func_num_args()>0)
		{
		$args = func_get_args();
		//获取参数并赋值
		$this->cookieName = $args[0];

		$this->cookieValue = $args[1];

		$this->cookieExpire = $args[2];

		$this->cookieMake();
		}
	}

	public function cookieMake()
	{
		try
		{
			if($this->cookieName!='' && $this->cookieValue!='' && $this->cookieExpire!='')
			{
			setcookie($this->cookieName,$this->cookieValue,time()+$this->cookieExpire);
			//创建Cookie，设置Cookie名字、值和有效期
			}
			else
			{
				throw new exception(“您必须设置Cookie名字和有效期”);
			}
		}
		catch(exception $e)
		{
			echo $e->getmessage();
		}
	}
	/**
	* 修改指定Cookie的值
	* @param string $newValue
	* @return null
	*/

	public function changeCookie($newValue)
	{
		$_COOKIE["$this->cookieName"] = $newValue;
	}

	/**
	* 从指定Cookie获取值
	* @return string
	*/

	public function getCookieValue()
	{
		return $_COOKIE["$this->cookieName"];
	}

	/**
	* 删除Cookie中的某个值
	*/

	public function removeCookie()
	{
		setcookie($this->cookieName,$this->cookieValue,time()-3600);
	}

}

?>