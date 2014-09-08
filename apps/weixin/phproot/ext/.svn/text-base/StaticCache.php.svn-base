<?php 
ob_start(); 
/** 
* @author peter
* @copyright 2013-09-26
* @param string $cache_folder 缓文件夹
* @param int $cache_create_time 文件缓存时间
*/
class StaticCache{
  private $cache_folder = null;             //cacher文件夹
  private $wroot_dir = null;                //站点目录
  private $cacher_create_time = null;      //cacher文件的建立时间
    
  public function __construct($cache_foldername,$cacher_time = 100) {
    ob_start();
    $this->wroot_dir = $_SERVER['DOCUMENT_ROOT'];
    //echo $this->wroot_dir;exit;
    $this->cache_folder = $cache_foldername;
    $this->cacher_create_time = $cacher_time;
  }

  public function read_cache() {
   try {   
      if(self::create_folder($this->cache_folder)) {
       self::get_cache();//输出缓存文件信息
      } else {
       echo "缓存文件夹创建失败!";
       return false;
      }
    } catch (Exception $e){
      echo $e;
      return false;
   }
  }

  //测试缓存文件夹是否存在 
  private function exist_folder($foler) {
     if(file_exists($this->wroot_dir."/".$foler)){
        return true;
     }else {
        return false;
     }    
  }

  //建立一个新的文件夹
  private function create_folder($foler) {
    if(!self::exist_folder($foler)) {
      try {
         mkdir($this->wroot_dir."/".$foler,0777);
         chmod($this->wroot_dir."/".$foler,0777);
         return true;
      } catch (Exception $e) {
         self::get_cache();//输出缓存
         return false;
      }
         return false;
     } else {
         return true;
     }
  }

  //读取缓存文件
  private function get_cache() {  
    $file_name = self::get_filename();  
    if (file_exists($file_name) || ((filemtime($file_name)+$this->cacher_create_time) > time())) {
      $content = file_get_contents($file_name);
      if($content) { 
        echo $content;  
        ob_end_flush();
        exit;
      } else {
        echo "文件读取失败";
        exit;
       }
    }
  }

  public function check() {
    $file_name = self::get_filename();
    if(file_exists($file_name)) {
      return true;
    } else {
      return false;
    }
  }

  //返回文件的名字
  private function get_filename() {
    $filename=$file_name=$this->wroot_dir.'/'.$this->cache_folder.'/'.md5($_SERVER['QUERY_STRING']).".html"; 
    return $filename;
  }
     
  //建立缓存文件
  public function create_cache() {
    $filename=self::get_filename();
    if($filename!="") {
       try{
        file_put_contents($filename,ob_get_contents()); 
        ob_implicit_flush(0);
        return true;
       } catch (Exception $e) {
         echo "写缓存失败:".$e;
         exit();
       }
      return true;
    } 
  }
      
  // 取得缓存中的所有文件
  public function list_file() {
    $path=$this->cache_folder;
    if($handle = opendir($path)) { 
      while (false !== ($file = readdir($handle))) {
        if($file!="." && $file!="..") {
          $path1=$path."/".$file;        
          if(file_exists($path1)) {       
          $result[]=$file;
          }                 
        }
      }    
      closedir($handle);
    }
    return $result; 
  }

  //删除缓存中的所有文件
  public function del_file() {
    $path=$this->cache_folder;
    if ($handle = opendir($path)) { 
      while (false !== ($file = readdir($handle))) {
        if($file!="." && $file!="..") {
          $path1=$path."/".$file;        
          if(file_exists($path1)) {         
            unlink($path1);         
          }                 
        }
      }    
      closedir($handle);
    }
     return true;  
  }

}

//$cache = new StaticCache('./_cache',100)
//$cache -> read_cache() 读取缓存并输出
//$cache -> create_cache() 创建缓存文件(放在文件未尾)
//$cache -> list_file() 返回所有缓存文件列表
//$cache -> del_file() 删除所有缓存文件

?>