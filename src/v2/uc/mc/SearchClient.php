<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/4/27
 * Time: 15:31
 */

namespace hupfc\k8uc\src\v2\uc\mc;


use hupfc\k8uc\src\Config;
use hupfc\k8uc\src\CurlAbstract;

class SearchClient extends CurlAbstract
{
    protected static $self;
    public $uri;
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
        self::$self->uri = Config::$domain['uc']['mc'].'/search/';
        return self::$self;
    }


    /**
     * @param $keyword
     * @param int $page
     * @param int $limit
     * 模糊匹配
     */
    public function netGameKeyMatch($keyword,$page=1,$limit=10){
        $url = $this->uri.strtolower(__FUNCTION__);
        $params = [
            'keyword'=>$keyword,
            'page'=>$page,
            'limit'=>$limit,
        ];
        $params = array_merge($this->params,$params);
        return $this->get($url,$params);
    }
}