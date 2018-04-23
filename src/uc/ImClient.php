<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/3/16
 * Time: 20:42
 */

namespace hupfc\k8uc\src\uc;




use hupfc\k8uc\src\Config;

class ImClient extends CurlAbstract
{
    protected static $self;
    /**
     * @return ImClient
     * 用于静态方式 单例方式调用类
     */
    public static function self()
    {
        if (self::$self && self::$self instanceof self) {
            return self::$self;
        }
        self::$self = new self();
        self::$self->uri = Config::$domain['uc']['mc'].'/im/';
        return self::$self;
    }
    public $uri;

    //获得皮肤 皮肤列表 type: 1皮肤 2披风 tips:筛选项
    public function getList($uid=false,$type,$tips,$limit,$page){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'type'=>$type,
            'tips'=>$tips,
            'limit'=>$limit,
            'page'=>$page
        ];
        $params = array_merge($this->params,$data);
        return $this->get($url,$params);
    }

    //获得皮肤 皮肤列表 type: 1皮肤 2披风 tips:筛选项
    public function getMyList($uid=false,$type,$tips,$limit,$page){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'type'=>$type,
            'tips'=>$tips,
            'limit'=>$limit,
            'page'=>$page
        ];
        $params = array_merge($this->params,$data);
        return $this->get($url,$params);
    }

    //获得皮肤 皮肤列表 type: 1皮肤 2披风
    public function getImInfo($id,$type){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'id'=>$id,
            'type'=>$type
        ];
        $params = array_merge($this->params,$data);
        return $this->get($url,$params);
    }
}