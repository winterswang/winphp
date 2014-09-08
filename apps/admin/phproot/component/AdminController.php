<?php
class AdminController extends BaseController{
	
	public $session = NULL;
	public $member = NULL;
	
	public $_G = array();
	
	public function init(){
		$this->session = new Session();
		$this->_init_member();
	}
	
	
    public function beforeAction($action)
    {
    	if ($this->getId() == 'member' && $action->getId() == 'reg') {
    		return true;
    	}
		if ($this->getId() == 'passport') {
			if (in_array($action->getId(), array('login'))) {
				if (!$this->is_guest()) {
					$this->redirect($this->getReferer());
				}
			}
		}else {
			if ($this->is_guest()) {
				$referer = WinBase::app()->getUri()->getUri();
				$this->redirect('/passport/login?referer=' . $referer);
			}
		}
		return true;
	}
	
	
	private function _init_member(){
        $login_member = $this->session->get('login_user');		
        if (!empty($login_member)) {
            $member = $login_member;
        } else {
            $member = array('uid' => 0, 'realName'=>'guest');
        }
        $this->_G['member'] = $member;
	}
	
	public function is_guest(){
		return $this->_G['member']['uid'] == 0;
	}
	
	public function redirect($url)
	{
		header('Location: '.$url);
		exit();
	}	
	
    function getReferer($referer = '')
    {

        if (empty($referer)) {
            $referer = WinBase::app()->getRequest()->getParam('referer');
            $referer = !empty($referer) ? $referer : WinBase::app()->getUri()->getUri();
        }

        if (strpos($referer, 'passport')) {
            $referer =  '/';
        }

        $referer = htmlspecialchars($referer);
        $referer = str_replace('&amp;', '&', $referer);
        $reurl = parse_url($referer);

        if (!isset($reurl['host'])) {
            $referer = '/'.ltrim($referer, '/');
        }
        return strip_tags($referer);
    }

    function getClientip()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] AS $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }
        return $ip;
    }
}
?>
