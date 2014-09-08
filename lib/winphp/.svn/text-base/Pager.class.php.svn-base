<?php
class Pager {

	public static function multi($num, $perpage, $curpage, $mpurl='', $maxpages = 0, $page = 10, $autogoto = FALSE, $simple = FALSE, $jsfunc = FALSE) {

		if(!$mpurl){
			unset($_GET['page']);
			$mpurl = self::getUri();

			//$mpurl .= (!empty($_GET)) ? '?'.http_build_query($_GET) : '';
		}
		//echo $mpurl;exit;

		$a_name = '';
		if(strpos($mpurl, '?') !== FALSE) {
			$a_strs = explode('?', $mpurl);
			$mpurl = $a_strs[0];
			
			$pieces = explode("&", $a_strs[1]);
			$arr = array();
			for ($i=0; $i<count($pieces); $i++){
				if (strpos($pieces[$i], 'page=')===false) {
					$arr[] = $pieces[$i];
				}
			}
			$a_name = count($arr) ? implode('&amp;', $arr).'&amp;' : '';
			//echo $a_name;
		}
		if($jsfunc !== FALSE) {
			$mpurl = 'javascript:'.$mpurl;
			$a_name = $jsfunc;
			$pagevar = '';
		} else {
			$pagevar = 'page=';
		}

		$shownum = $showkbd = FALSE;
		$showpagejump = TRUE;

		$lang['prev'] = 'prev';
		$lang['next'] = 'next';

		$lang['pageunit'] = 'unit';
		$lang['total'] = 'total';
		$lang['pagejumptip'] = 'jumptip';


		$dot = '...';

		$multipage = '';
		if($jsfunc === FALSE) {
			$mpurl .= strpos($mpurl, '?') !== FALSE ? '&amp;' : '?';
		}

		$realpages = 1;

		$page -= strlen($curpage) - 1;
		if($page <= 0) {
			$page = 1;
		}
		if($num > $perpage) {

			$offset = floor($page * 0.5);

			$realpages = @ceil($num / $perpage);
			$curpage = $curpage > $realpages ? $realpages : $curpage;
			$pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;

			if($page > $pages) {
				$from = 1;
				$to = $pages;
			} else {
				$from = $curpage - $offset;
				$to = $from + $page - 1;
				if($from < 1) {
					$to = $curpage + 1 - $from;
					$from = 1;
					if($to - $from < $page) {
						$to = $page;
					}
				} elseif($to > $pages) {
					$from = $pages - $page + 1;
					$to = $pages;
				}
			}

			$multipage = ($curpage > 1 && !$simple ? '<a href="'.$mpurl.$a_name.$pagevar.($curpage - 1).'" class="prev">'.$lang['prev'].'</a>' : '').
			($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.$a_name.$pagevar.'1'.'" class="first">1 '.$dot.'</a>' : '');
			
			for($i = $from; $i <= $to; $i++) {
				$multipage .= $i == $curpage ? '<strong>'.$i.'</strong>' :
				'<a href="'.$mpurl.$a_name.$pagevar.$i.'"'.'>'.$i.'</a>';
			}
			$multipage .= ($to < $pages ? '<a href="'.$mpurl.$a_name.$pagevar.$pages.'" class="last">'.$dot.' '.$realpages.'</a>' : '').
			//($showpagejump && !$simple ? '<label><input type="text" name="custompage" class="px" size="2" title="'.$lang['pagejumptip'].'" value="'.$curpage.'" onkeydown="if(event.keyCode==13) {window.location=\''.$mpurl.$pagevar.'\'+this.value; doane(event);}" /><span title="'.$lang['total'].' '.$pages.' '.$lang['pageunit'].'"> / '.$pages.' '.$lang['pageunit'].'</span></label>' : '').
			($curpage < $pages && !$simple ? '<a href="'.$mpurl.$a_name.$pagevar.($curpage + 1).'" class="nxt">'.$lang['next'].'</a>' : '');
			//($showkbd && !$simple && $pages > $page ? '<kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\''.$mpurl.$pagevar.'\'+this.value; doane(event);}" /></kbd>' : '');

			$multipage = $multipage ? '<div class="pagination">'.($shownum && !$simple ? '<em>&nbsp;'.$num.'&nbsp;</em>' : '').$multipage.'<span>总数:'.$num.'</span></div>' : '';
		}
		$maxpage = $realpages;
		return $multipage;
	}

	public static function simplepage($num, $perpage, $curpage, $mpurl = '') {
		$mpurl = !$mpurl ? preg_replace("/&page=\\d+/i","",$_SERVER['REQUEST_URI']) : $mpurl;
		$return = '';
		$lang['next'] = 'next';
		$lang['prev'] = 'prev';
		$next = $num == $perpage ? '<a href="'.$mpurl.'&amp;page='.($curpage + 1).'" class="nxt">'.$lang['next'].'</a>' : '';
		$prev = $curpage > 1 ? '<span class="pgb"><a href="'.$mpurl.'&amp;page='.($curpage - 1).'">'.$lang['prev'].'</a></span>' : '';
		if($next || $prev) {
			$return = '<div class="pg">'.$prev.$next.'</div>';
		}
		return $return;
	}


	public static function getUri()
	{
		$uri = '';
        $page_name = $_SERVER['REQUEST_URI'];  
        $params = $_SERVER['QUERY_STRING'];  
        $params_str = '';  
        if(!empty($params)) {  
            $params = str_replace('&amp;', '&', $params);  
            $params_array = explode('&', $params);  
            foreach($params_array as $param) {  
                if(!empty($param)) {  
                    $index = strpos($param, '=');  
                    if($index) {  
                        $key = substr($param, 0, $index);  
                        if($key && $key != 'page')  
                            $params_str .= $param . '&';  
                    }  
                }  
            }  
        }
		
        if(!empty($params_str))  
            $uri = $page_name . '?' . $params_str;  
        else  
            $uri = $page_name;  
        $uri = rtrim($uri,'&');  
		return $uri;
	}	
}