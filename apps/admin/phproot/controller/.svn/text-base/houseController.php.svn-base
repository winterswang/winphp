<?php
/**
 * 房源管理
 */
class houseController extends AdminController {
    
	/**
	 * 房源列表
	 */
    public function actionIndex()
    {
		
    }

    /**
     * 一键搬家
     */
    public function actionKeymove() {
    	
		
		$req = WinBase::app()->getRequest();
        if($req->isAjaxRequest()){
        	$store_link = $req->getParam("store_link");
            $agent_url = $req->getParam("agent_url");
			$item = array('url'=>$store_link, 'agent_url' => $agent_url);
			$item['uid'] = $this->_G['member']['uid'];
            $moveStatus = $this -> moveStatus($item);
            if(empty($moveStatus)) {
                store_links::model()->addStoreLinks($item);
                $res = array('msg'=>'ok');
                echo json_encode($res);
                exit; 
            } else {
                echo json_encode($moveStatus);
                exit;
            }	
		}
    	$data = array('menu' => 'm_pub');
    	$this -> render('key_move', $data);
    }
	
    /**
     * 检查搬家状态
     */
    public function moveStatus($arr) {
        if(is_array($arr) && !empty($arr)) {
            $res = store_links :: model() -> getInfo($arr);
            return $res;
        }
    }

    /**
     * 个人店铺
     */
    public function actionMinestore() {
        $data = array('menu' => 'm_pub');
        $this -> render('mine_store', $data);
    }

    /**
     * 一键搬家状态
     */
    public function actionMovehouse() {
		$req = WinBase::app()->getRequest();
        $store_url = $req -> getParam("store_url", "");
        if($req -> isAjaxRequest()) {
            $url = $req -> getParam("url", "");
            if(!empty($url)) {
                $res = store_links::model() -> getInfo(array("url" => $url)); 
                if(!empty($res)) {
                    echo json_encode($res);
                    exit;
                }
            }
        }
		$data = array('menu' => 'm_pub', 'store_url' => $store_url);
        $this -> render('move_house', $data);

    }
	
	
	/**
	 * 发布房源
	 */
    public function actionAdd()
    {
    	$data = array('menu' => 'm_pub');
		$this->render("house_publish", $data);

    }	
	
	/**
	 * 修改房源
	 */
    public function actionModify()
    {

    }
	
	/**
	 * 删除房源
	 */
    public function actionDelete()
    {

    }
	
	/**
	 * 房源预览
	 */
	 public function actionPreview() {
	 	
	 }
}