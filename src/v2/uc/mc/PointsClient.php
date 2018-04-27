<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/24 0024
 * Time: 下午 4:59
 */

namespace hupfc\k8uc\src\v2\uc\mc;

use hupfc\k8uc\src\Config;
use hupfc\k8uc\src\CurlAbstract;

/**
 * Class PointsClient
 * @package hupfc\k8uc\src\v2\uc\mc
 * 点卷类
 */
class PointsClient extends CurlAbstract
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
        self::$self->uri = Config::$domain['uc']['mc'].'/point/';
        return self::$self;
    }
    public $uri;

    /**
     * 通过sid，游戏昵称，account查询用户还有多少点券
     * @param array $options
     *                  sid:551
     *                  nickname:huyw
     *                  account:551
     *
     * @return array
     *              code
     *              msg
     *              data:
     *                  order_num
     */
    public function getUserPoint(Array $options){
        $url = $this->uri.strtolower(__FUNCTION__);
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }
}