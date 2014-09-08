<?php

define('PINYINEXT_PATH',dirname(__file__));

class pinyinExt {
    
    public static $pinyinData = null;
    public static $UC2GBTABLE = null;
    
    public $iconv_enbled;

    function __construct(){
        $this->iconv_enbled = function_exists('iconv') === true;
    }
    
    function load_pinyin_resouce(){
        
        if(self::$pinyinData == null){
            $fp = fopen(PINYINEXT_PATH.'/data/pinyin.dat', 'r');
            while(!feof($fp))
            {
                $line = trim(fgets($fp));
                self::$pinyinData[$line[0].$line[1]] = substr($line, 3, strlen($line)-3);
            }
            fclose($fp);
        }
        
        return self::$pinyinData;
    }
    
    function load_uc2gb_resouce(){

        if(self::$UC2GBTABLE == null)
        {
            $fp = fopen(PINYINEXT_PATH."/data/gb2312-utf8.dat","r");
            while($l = fgets($fp,15))
            {
                self::$UC2GBTABLE[hexdec(substr($l, 7, 6))] = hexdec(substr($l, 0, 6));
            }
            fclose($fp);
        }
        
        return self::$UC2GBTABLE;
    }    

    public function getPinyin($str,$split='',$firstUpper=0,$ishead=0)
    {
      
        $str = $this->iconv_enbled ? iconv('utf-8','gbk//ignore',$str) : $this->utf82gb($str);
        
        $this->load_pinyin_resouce();
        
        $restr = '';
        $str = trim($str);
        $slen = strlen($str);
        if($slen < 2)
        {
            return $str;
        }

        for($i=0; $i<$slen; $i++)
        {
            if(ord($str[$i])>0x80)
            {
                $c = $str[$i].$str[$i+1];
                $i++;
                if(isset(self::$tsData[$c]))
                {
                    if($ishead==0)
                    {
                        $restr .= $split.($firstUpper ? ucfirst(self::$tsData[$c]) : self::$tsData[$c] );
                    }
                    else
                    {
                        $restr .= $split.($firstUpper ? ucfirst( self::$tsData[$c][0] ) : self::$tsData[$c] );
                    }
                }else
                {
                    $restr .= "_";
                }
            }else if( preg_match("/[a-z0-9]/i", $str[$i]) )
            {
                $restr .= $split.$str[$i];
            }
            else
            {
                //$restr .= $split."_";
                $restr .= $split;
            }
        }

        return trim($restr,$split."_");
    }
    
    function utf82gb($utfstr)
    {
        $this->load_uc2gb_resouce();
        
        $okstr = "";
        if(trim($utfstr)=="")
        {
            return $utfstr;
        }

        $okstr = "";
        $ulen = strlen($utfstr);
        for($i=0;$i<$ulen;$i++)
        {
            $c = $utfstr[$i];
            $cb = decbin(ord($utfstr[$i]));
            if(strlen($cb)==8)
            {
                $csize = strpos(decbin(ord($cb)),"0");
                for($j=0;$j < $csize;$j++)
                {
                    $i++; $c .= $utfstr[$i];
                }
                $c = $this->utf82u($c);
                if(isset(self::$UC2GBTABLE[$c]))
                {
                    $c = dechex(self::$UC2GBTABLE[$c]+0x8080);
                    $okstr .= chr(hexdec($c[0].$c[1])).chr(hexdec($c[2].$c[3]));
                }
                else
                {
                    $okstr .= "&#".$c.";";
                }
            }
            else
            {
                $okstr .= $c;
            }
        }
        $okstr = trim($okstr);
        return $okstr;
    }
    
    function utf82u($c)
    {
        switch(strlen($c))
        {
            case 1:
                return ord($c);
            case 2:
                $n = (ord($c[0]) & 0x3f) << 6;
                $n += ord($c[1]) & 0x3f;
                return $n;
            case 3:
                $n = (ord($c[0]) & 0x1f) << 12;
                $n += (ord($c[1]) & 0x3f) << 6;
                $n += ord($c[2]) & 0x3f;
                return $n;
            case 4:
                $n = (ord($c[0]) & 0x0f) << 18;
                $n += (ord($c[1]) & 0x3f) << 12;
                $n += (ord($c[2]) & 0x3f) << 6;
                $n += ord($c[3]) & 0x3f;
                return $n;
        }
    }
    
    function __destruct(){
        self::$pinyinData = null;
        self::$UC2GBTABLE = null;
    }
}