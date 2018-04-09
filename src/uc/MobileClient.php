<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/3/20
 * Time: 11:35
 */

namespace hupfc\k8uc\src\uc;



use hupfc\k8uc\src\Config;

class MobileClient extends CurlAbstract
{
    protected static $self;
    /**
     * @return MobileClient
     * 用于静态方式 单例方式调用类
     */
    public static function self()
    {
        if (self::$self && self::$self instanceof self) {
            return self::$self;
        }
        self::$self = new self();
        return self::$self;
    }

    public $uri = false;
    public function __construct()
    {
        parent::__construct();
        $this->uri = Config::$domain['uc']['user'].'/mobile/';
    }


    public function send($mobile,$content,$mac){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'mobile'=>$mobile,'content'=>$content,'mac'=>$mac
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }
    
    public function checkMobile($mobile){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'mobile'=>$mobile
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }

    public function reg($mobile,$code,$password){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'mobile'=>$mobile,'code'=>$code,'password'=>$password
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }
}