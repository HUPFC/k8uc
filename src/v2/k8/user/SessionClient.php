<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/2/28
 * Time: 13:54
 */
namespace hupfc\k8uc\src\v2\k8\user;



use hupfc\k8uc\src\Config;
use hupfc\k8uc\src\CurlAbstract;

class SessionClient extends CurlAbstract
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
        self::$self->uri = Config::$domain['k8']['user'].'/session/';
        return self::$self;
    }

    public $uri;

    /**
     * @param $uid
     * @return array.data.token
     * 用于跨应用登录，通过uid获取token
     */
    public function create($uid){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'uid'=>$uid,
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }

    /**
     * @param $token
     * @return array.data.userInfo
     * 用于跨应用登录，通过token 获取用户信息
     */
    public function getByToken($token){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'token'=>$token,
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }

}