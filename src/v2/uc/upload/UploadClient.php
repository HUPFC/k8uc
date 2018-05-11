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

class UploadClient extends CurlAbstract
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
        self::$self->uri = Config::$domain['uc']['upload'].'/upload/';
        return self::$self;
    }

    public $uri;

    public function checkMd5($md5){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'md5'=>$md5,
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }

    public function upload(){

    }

}