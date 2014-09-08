<?php
class systemController extends ApiController {
    
    public function actionPreload(){
        
        $user_info = $this->member->getMember();
        //$pushsetting =  user::model()->getPushSetting($user_info['uid']);
		
		$house_rows = house::model()->getAll(array('uid'=>$user_info['uid'],'is_delete'=>0));
		$user_house = array();
		foreach($house_rows as $row){
			$user_house[] = $row['house_guid'];
		}
		
		if(in_array($this->member->mobile,array('15921152900','13818683662','13761550752','15821218116','13651736387','15026892606','13671903887','13661709162','13918725808','13621803756','15221796665','15821301366'))){
			$this->group['max_post'] = 5;
		}
		
        $preload = array(
            'user_info' => $user_info,
			'user_house' => $user_house,
			'group_id' => $this->group['group_id'],
			'max_post' => $this->group['max_post'],
            'systemsetting' => Config::getConfig('system')
        );

        $this->response($preload);
    }
	
	public function actionCheckupdate(){
        $data = array(
            'version_number' => '1.10',
			'release_time' => mktime(0,0,0,1,date('m'),date('Y')),
			'updates' => ""
        );

        $this->response($data);
	}

    public function actionGetResource(){
        
        $resouse = array(
            'subway_list' => common::model()->getSubWayList(),
            'area_list' => common::model()->getAreaList(),
        );
        
        $this->response($resouse);
    }
    
    public function actionGetZone(){
		$req = WinBase::app()->getRequest();
		$area_id = $req->getParam('area_id',0);
        $this->response();
    }
    
    public function actionRegpusher(){
		$req = WinBase::app()->getRequest();
		$token = $req->getParam('token','');
        $pushbadge = $req->getParam('pushbadge','');
        $pushalert = $req->getParam('pushalert','');
        $pushsound = $req->getParam('pushsound','');

        $report_arr = array(
            'token' => $token,
            'pushbadge' => $pushbadge,
            'pushalert' => $pushalert,
            'pushsound' => $pushsound
        );
        
        device::model()->updateDevice($report_arr,array('device_id'=>$this->session->device_id));

        $this->response();
    }
    
    public function actionReport(){
		$req = WinBase::app()->getRequest();
		$type = $req->getParam('type','');
        $report = $req->getParam('report','');
        $target = (int)$req->getParam('target',0);
		
		$count = systemReport::model()->getCount(array('type' => $type,'target' => $target,'report' => $report,'uid' => $this->member->uid));
		if($count){
			 $this->response();
		}
		
        $report_arr = array(
            'type' => $type,
			'target' => $target,
            'report' => $report,
            'uid' => $this->member->uid,
            'dateline' => TIMESTAMP
        );
        
        systemReport::model()->addReport($report_arr);
        
        $this->response();
    }
    
    public function actionValidcode(){
        
        $req = WinBase::app()->getRequest();
		$mobile = $req->getParam('mobile',0);
		$force = $req->getParam('force',0);
		
        
		$sms_validate = Config::getConfig('system','sms_validate');
		if(!$force && !$sms_validate){
			 $this->response();
		}
		
        if(!preg_match("/^13[0-9]{1}[0-9]{8}$|15[012356789]{1}[0-9]{8}$|18[012356789]{1}[0-9]{8}$|14[57]{1}[0-9]$/",$mobile)){
            $this->showError('9016','mobile vaild');
        }

        systemValidcode::model()->deleteCode(array('uid' => $this->member->uid));
        
		$seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, 10); // num 10 ,str 35
		$seed = str_replace('0', '', $seed) . '012340567890';

        $code = '';
        $max = strlen($seed) - 1;
        for ($i = 0; $i < 6; $i++) {
            $code .= $seed{mt_rand(0, $max)};
        }

        $msg = " %d (快租验证码) ";
        $msg = sprintf($msg,$code);        
        
        $sms = new smsExt('shajwl','shajwl1');
        $res = $sms->post_msg($msg,$mobile);
        if(!isset($res->code) || !in_array($res->code,array("00",'01','03'))){
            $this->showError('9999','sms error :'.$res->code);
        }
        
        $arr = array(
            'code' => $code,
            'uid' => $this->member->uid,
            'dateline' => TIMESTAMP,
        );
        
        if(!systemValidcode::model()->addCode($arr)){
            $this->showError('9999','sql error');
        }
        
        $this->response();
    }
	
	function actionFeedback(){
        $req = WinBase::app()->getRequest();
		$email = $req->getParam('email','');
		$content = $req->getParam('content','');
		
		$arr = array(
			'email' => $email,
			'content' => $content,
			'uid' => $this->member->uid,
			'dateline' => TIMESTAMP
		);
		
        if(!systemFeedback::model()->addFeedback($arr)){
            $this->showError('9999','sql error');
        }
		
		$this->response();
	}
}
