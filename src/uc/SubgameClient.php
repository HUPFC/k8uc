<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/3/20
 * Time: 11:35
 */

namespace hupfc\k8uc\src\uc;



use hupfc\k8uc\src\Config;
use hupfc\k8uc\src\uc\CurlAbstract;

class SubgameClient extends CurlAbstract
{
    protected static $self;
    /**
     * @return SubgameClient
     * 用于静态方式 单例方式调用类
     */
    public static function self()
    {
        if (self::$self && self::$self instanceof self) {
            return self::$self;
        }
        self::$self = new self();
        self::$self->uri = Config::$domain['uc']['mc'].'/subgame/';
        return self::$self;
    }

    public $uri = false;
    public function __construct()
    {
        parent::__construct();
        $this->uri = Config::$domain['uc']['mc'].'/subgame/';
    }

    public function getInfo($sid,$nickname){
        $url = $this->uri.'.'.strtolower(__FUNCTION__);
        $options = [
            'sid'=>$sid,'nickname'=>$nickname
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }

    public function getList($sid,$uid){
        $url = $this->uri.'.'.strtolower(__FUNCTION__);
        $options = [
            'sid'=>$sid,'uid'=>$uid
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }

    public function addInfo($sid,$uid,$name){
        $url = $this->uri.'.'.strtolower(__FUNCTION__);
        $options = [
            'sid'=>$sid,'uid'=>$uid,'nickname'=>$name
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }
}