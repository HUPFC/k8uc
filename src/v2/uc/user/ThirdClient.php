<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/2/28
 * Time: 13:54
 */

namespace hupfc\k8uc\src\v2\uc\user;



use hupfc\k8uc\src\Config;
use hupfc\k8uc\src\uc\CurlAbstract;

class ThirdClient extends CurlAbstract
{

    protected static $self;
    /**
     * @return self
     * 用于静态方式 单例方式调用类
     */
    public static function self()
    {
        if (self::$self && self::$self instanceof self) {
            return self::$self;
        }
        self::$self = new self();
        self::$self->uri = Config::$domain['uc']['user'].'/third/';
        return self::$self;
    }

    public $uri;

    public function qqLogin($openid,$unionid=false,$name=false,$header=false){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'openid'=>$openid,
            'thirdname'=>$name,
            'thirdheader'=>$header,
            'unionid'=>$unionid
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }

    public function qqUnBind($uid,$openid){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'openid'=>$openid,
            'uid'=>$uid,
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }

    public function qqBind($uid,$openid,$name=false,$header=false){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'openid'=>$openid,
            'uid'=>$uid,
            'thirdname'=>$name,
            'thirdheader'=>$header
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }

    public function wxLogin($openid,$unionid=false,$name=false,$header=false){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'openid'=>$openid,
            'thirdname'=>$name,
            'thirdheader'=>$header,
            'unionid'=>$unionid
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }

    public function wxUnBind($uid,$openid){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'openid'=>$openid,
            'uid'=>$uid,
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }

    public function wxBind($uid,$openid,$name=false,$header=false){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'openid'=>$openid,
            'uid'=>$uid,
            'thirdname'=>$name,
            'thirdheader'=>$header
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }


    public function mobileReg($mobile,$password){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'mobile'=>$mobile,
            'password'=>$password,
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }

    public function mobileLogin($mobile,$password){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'mobile'=>$mobile,
            'password'=>$password,
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }

    public function mobileChange($uid,$new_mobile){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'uid'=>$uid,
            'new_mobile'=>$new_mobile
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }
    
    public function checkInit($uid) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'uid'=>$uid
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }
    
    public function updateInit($uid,$password) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'uid'=>$uid,
            'password'=>$password
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }

    public function thirdVerify($openid,$type){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'openid'=>$openid,
            'type'=>$type
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }
}