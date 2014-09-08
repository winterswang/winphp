<?php
/**
 * 客户留言
 */
class msgController extends AppController
{
	/**
	 * 给中介留言
	 */
    public function actionMsgAgent(){

    }
	
	/**
	 * 系统留言
	 */
	public function actionMsgUs() {
		$req = WinBase::app()->getRequest();
		if ($req->isPostRequest()) {
			$data = array();
			$q = $req->getParam("q",'');
			if ($q == '') {
				$data['res'] = 'error';
				$data['msg'] = '请输入问题';
				echo json_encode($data);
            	exit; 
			}
			$n = $req->getParam("n",'');

			$tel = $req->getParam("tel",'');
			if ($tel == '') {
				$data['res'] = 'error';
				$data['msg'] = '留一下您的联系方式吧';
				echo json_encode($data);
            	exit;
			}
			//TODO to api
			$d = array($q, $n, $tel);
			file_put_contents('/tmp/msg.txt', implode(',', $d)."\n", FILE_APPEND);
			$data['res'] = 'OK';
			$data['msg'] = '感谢您的留言';
			echo json_encode($data);
			exit;
		}
        $this->render("msg");
	}


	public function actionMem() {
	 	$mem = new Memcache;
		$mem->connect("127.0.0.1", 11211);
	 	$mem->set('key', 'This is a test!', 0, 60);
		$val = $mem->get('key');
	 	echo $val;
	}

	public function actionTpl() {
		$this -> render('tpl');
	}
}
?>