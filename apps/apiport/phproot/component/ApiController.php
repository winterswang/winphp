<?php
class ApiController extends BaseController{
	
	private $microtime;
    private static $_store = NULL;
	public $session = NULL;
	public $member = NULL;
	public $group = NULL;
	public $output_format = 'json';
	public $logger = null;
	
	public $is_mobile = false;
	public $is_new = false;
	public $platform = array();
	public $req_header = array('uuid'=>'','latlng'=>'0,0','clientid'=>0,'platform'=>'');
	
	public function init()
	{
		/*
		$this->microtime = microtime(true);
		
		$auth = new authValidate();
		if(!$auth->validate()){
			$error = $auth->getError();
			$this->showError($error['code'],$error['info']);
		}
		*/
		$header = WinBase::app()->getRequest()->getHeaders();
		$this->req_header = array_merge($this->req_header,$header);
	
	}
	
    public function beforeAction($action)
    {
    	/*
		$this->_validate_require($action);
		$this->_validate_params($action);
		
		if($this->req_header['clientid'] == '1003'){//爬虫的客户端ID是1003
			return true;
		}
		
		$this->_init_platform();
		$this->_init_session();
		$this->_init_member();
		*/
		return true;
	}
	
    protected function validate()
    {
        return array();
    }
	
	private function _init_platform() {//平台类型
		
		$uuid = $this->req_header['uuid'];
		$platform = $this->req_header['platform'];

		$mobileDetect = new detectExt();
		$this->is_mobile = $mobileDetect->isMobile();

		$platform_arr = userPlatfrom::model()->getInfoByUUid($uuid,$platform);
		if(empty($platform_arr)){//数据库未找到，视为新设备
			$arr = array(
				'uuid'      => $uuid,
				'platform'  => $platform,
				'uid'       => 0,
				'device_id' => 0,
				'dateline'  => TIMESTAMP,
			);
			
			if(!($pid = userPlatfrom::model()->addBind($arr,true))){//把该使用平台存入数据库
				$this->showError('9999','init platform faild');
			}
			
			$arr['pid'] = $pid;
			$platform_arr = $arr;
			
			$this->is_new = true;
		}
		
		if($this->is_mobile && $this->is_new){	
			$device = array(
				'uuid' => $uuid,
				'os' => $this->req_header['osversion'],
				'platform' => $this->req_header['platform'],
				'model' => $this->req_header['model'],
				'token' => '',
				'pushbadge' => 'disabled',
				'pushalert' => 'disabled',
				'pushsound' => 'disabled',            
				'createtime' => TIMESTAMP,
				'updatetime' => TIMESTAMP
			);
			
			if(!($device_id = device::model()->regDevice($device))){//把该设备类型插入数据库，返回一个设备号
				$this->showError('9999','Cann\'t reg device');
			}

			if(userPlatfrom::model()->updateBind(array('device_id' => $device_id),array('uuid'=>$uuid,'platform' => $platform))){
				$platform_arr['device_id'] = $device_id;
			}
			
		}
		
		$this->platform = $platform_arr;
	}
	
	private function _init_session() {
		$uuid = $this->req_header['uuid'];
		$client_id = $this->req_header['clientid'];
		
		$this->session = new requestSession($uuid,$client_id);
		
		list($lat,$lng) = explode(',',$this->req_header['latlng']);
		$this->session->set('lat',$lat);
		$this->session->set('lng',$lng);
		
		$uid = $this->session->get('uid',0);
		if(!$uid){
			$this->session->set('uid',$this->platform['uid']);
		}
	}
	
	private function _init_member(){
		$uid = $this->session->get('uid',0);
		
		$this->member = new memberCom($uid);
		
		if($this->is_new){
			$uid = $this->member->uid;
			$this->session->set('uid',$uid);
			
			$uuid = $this->platform['uuid'];
			$platform = $this->platform['platform'];
			userPlatfrom::model()->updateBind(array('uid' => $uid),array('uuid'=>$uuid,'platform' => $platform));
		}
		
		$this->_init_group();
	}
	
	private function _init_group(){
		$group = array();
		if($this->member->group_id > 0){
			$row = usergroup::model()->getInfo(array('group_id'=>$this->member->group_id));
			$group = array('group_id' => $row['group_id'],'max_post' => $row['max_post']);
		}
		
		if(empty($group)){
			$group = array('group_id' =>0 ,'max_post' => 1);
		}
		
		$this->group = $group;
	}
	
    private function _validate_require($action)
    {
		$req = WinBase::app()->getRequest();
		$rules = $this->validate();//返回
		$id = $action->getId();
		
        if (isset($rules['post']) && in_array($id,$rules['post'])) {	
			if(!$req->isPostRequest()){
				$this->showError('9020');
			}
        }
    }

    private function _validate_params($action)//
    {
		$request = WinBase::app()->getRequest();
        $rules = $this->validate();
		$id = $action->getId();
        if (isset($rules[$id])) {
            foreach ($rules[$id] as $key) {
                if ($request->getParam($key) === false || $request->getParam($key) === null || $request->getParam($key) === '') {
                    $this->showError('9016');
                }
            }
        }
    }
	
	public function showError($status = '',$info='',$http_status = 200){
		$resp = new stdClass();
		$resp->status = $status;
		$resp->info = !empty($info) ? $info : $this->_getStateCodeMessage($status);
		$resp->data = "123";
	
        $this->output($resp,$http_status);
	}

    public function response($data=array())
    {
		$resp = new stdClass();
		$resp->status = '0000';
		$resp->info = $this->_getStateCodeMessage('0000');
		$resp->runtime = microtime(TRUE) - $this->microtime;
		$resp->data = $data;
        // TODO cache it

		$this->output($resp,200);
    }
	
	public function output($resp,$http_status){
		
		$this->setHeader($http_status);
		
        if ($this->output_format == 'json') {
            echo Json::encode($resp);
        } else {
            echo $resp;
        }

       // $this->log();

        exit();
	}
	
	public function setHeader($http_status,$cache = false){
        $status_header = 'HTTP/1.1 ' . $http_status . ' ' . $this->_getHttpMessage($http_status);
        header($status_header);
		
        switch ($this->output_format) {
            case "json": $ctype = "application/json";
                break;
            case "text": $ctype = "text/plain";
                break;
            case "enctype": $ctype = "application/x-www-form-urlencoded";
                break;
            default: $ctype = "application/x-www-form-urlencoded";
        }
        header('Content-type: ' . $ctype);
		
        /*if (!$cache) {
            header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Pragma: no-cache');
        }*/		
	}

    private function _getHttpMessage($code)
    {
        static $_reason_phrase = array(
			// [Informational 1xx]
			'100' => 'Continue',
			'101' => 'Switching Protocols',
			// [Successful 2xx]
			'200' => 'OK',
			'201' => 'Created',
			'202' => 'Accepted',
			'203' => 'Non-Authoritative Information',
			'204' => 'No Content',
			'205' => 'Reset Content',
			'206' => 'Partial Content',
			// [Redirection 3xx]
			'300' => 'Multiple Choices',
			'301' => 'Moved Permanently',
			'302' => 'Found',
			'303' => 'See Other',
			'304' => 'Not Modified',
			'305' => 'Use Proxy',
			'306' => '(Unused)',
			'307' => 'Temporary Redirect',
			// [Client Error 4xx]
			'400' => 'Bad Request',
			'401' => 'Unauthorized',
			'402' => 'Payment Required',
			'403' => 'Forbidden',
			'404' => 'Not Found',
			'405' => 'Method Not Allowed',
			'406' => 'Not Acceptable',
			'407' => 'Proxy Authentication Required',
			'408' => 'Request Timeout',
			'409' => 'Conflict',
			'410' => 'Gone',
			'411' => 'Length Required',
			'412' => 'Precondition Failed',
			'413' => 'Request Entity Too Large',
			'414' => 'Request-URI Too Long',
			'415' => 'Unsupported Media Type',
			'416' => 'Requested Range Not Satisfiable',
			'417' => 'Expectation Failed',
			// [Server Error 5xx]
			'500' => 'Internal Server Error',
			'501' => 'Not Implemented',
			'502' => 'Bad Gateway',
			'503' => 'Service Unavailable',
			'504' => 'Gateway Timeout',
			'505' => 'HTTP Version Not Supported'
        );
        if (array_key_exists($code, $_reason_phrase)) {
            return $_reason_phrase[$code];
        }

        return 'Unknow error';
    }

    public function _getStateCodeMessage($code = 0)
    {
        static $statecode_messages = array(
			'9000' => 'Invalid Session',
			'9001' => 'Missing Method',
			'9002' => 'Invalid Method', // 不存在的方法名
			'9003' => 'Invalid Format', // 无效数据格式
			'9004' => 'Missing Signature', // 缺少签名参数
			'9005' => 'Invalid Signature', // 无效签名
			'9006' => 'Missing Token', // 缺少SessionKey参数
			'9007' => 'Invalid Token', // 无效的SessionKey参数
			'9008' => 'Missing Api Key', // 缺少ApiKey参数
			'9009' => 'Invalid Api Key', //无效的ApiKey参数
			'9010' => 'Missing Timestamp', // 缺少时间戳参数
			'9011' => 'Invalid Timestamp', // 非法的时间戳参数
			'9012' => 'Missing Version', // 缺少版本参数
			'9013' => 'Invalid Version', // 非法的版本参数
			'9014' => 'Unsupported Version', // 不支持的版本号
			'9015' => 'Insufficient session permissions', // 短授权权限不足
			'9016' => 'Parameter Error', // 参数错误
			'9017' => 'Invalid encoding', // 编码错误
			'9020' => 'Http Action Not Allowed HTTP', // HTTP方法被禁止
			'9999' => 'Internal Server Error',
			'0000' => 'Success'
        );

        if (array_key_exists($code, $statecode_messages)) {
            return $statecode_messages[$code];
        }

        return 'Unknow error';
    }

	public function log($msg,$category ='api',$level='')
	{
		if($this->logger===null)
			$this->logger=new Logger();
		
		$this->logger->setLogFile($category);
		$this->logger->processLogs(array($msg,$level,$category,time()));
	}

	
}
?>
