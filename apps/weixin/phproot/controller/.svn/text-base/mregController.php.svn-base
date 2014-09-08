<?php
class mregController extends AppController {
    public function actionReg() {
        $req = WinBase::app()->getRequest();
        $openId = $req -> getParam('openId', '');
        $data['openId'] = $openId;
        $this->setMeta('title','注册');
        $this->render("mreg_reg", $data);
    }
    public function actionInfo(){
        $req = WinBase::app()->getRequest();
        $res = array();
        if ($req->isPostRequest()) {
            do {
                $openId = $req -> getParam('openId', '');
                $agentName = $req->getParam('agentName','');
                /*
                if($agentName == '') {
                   $res['error'] = "请输入您的真实姓名";
                   break;
                }
                */
                $telephone = $req -> getParam('telephone', '');
                if($telephone == '') {
                   $res['error'] = "请输入您的手机号";
                   break;
                }
                $agentWxId = $req->getParam('agentWxId','');
                if($agentWxId == '') {
                   $res['error'] = "请输入您的微信号";
                   break;
                }
                $company = $req->getParam('company','');
                if($company == '') {
                   $res['error'] = "请输入您的公司名称";
                   break;
                }
                $storeName = $req->getParam('storeName','');
                if($storeName == '') {
                   $res['error'] = "请输入您的店铺名称";
                   break;
                }
                $position = $req->getParam('position','');
                if($position == '') {
                   $res['error'] = "请输入您的职位名称";
                   break;
                }
                $business = $req->getParam('business','');
                if($business == '') {
                    $res['error'] = '请输入您的擅长业务';
                    break;
                }
                /*
                $storeUrl = $req->getParam('storeUrl','');
                if($storeUrl == '') {
                    $res['error'] = '请输入您的店铺链接';
                    break;
                }
                */
                $data = array(
                    'openId'    => $openId,
                    'telephone' => $telephone,
                    'agentWxId' => $agentWxId,
                    'company'   => $company,
                    'storeName' => $storeName,
                    'position'  => $position,
                    'business'  => $business
                );
                //print_r($data);
                $ret = $this -> api -> add_agent_wx($data);
                if($ret['result'] == 'ok') {
                    $qrUrl = 'http://api.ikuaizu.com/data/attachment'.$ret['card_url'];
                    echo "<script>";
                    echo "window.location.href='{$qrUrl}';";
                    echo "</script>";
                }
                //print_r($ret);
            } while(0);

            //print_r($res);
        }
    }


    public function actionSendSms() {
        $content = rand(100000,999999);
        $to = '13436882177';
        $re = $this -> sms -> post_msg($content, $to);
        var_dump($re);

    }


}
?>