<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/4/12
 * Time: 13:33
 */

namespace hupfc\k8uc\src\v2\uc\order;


use hupfc\k8uc\src\Config;
use hupfc\k8uc\src\CurlAbstract;

class McClient extends CurlAbstract
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
        self::$self->uri = Config::$domain['uc']['order'].'/mc/';
        return self::$self;
    }
    public $uri;

    /**
     * 创建mc订单
     * @param array $options
     *                  uid:292
                        order_name:迪士尼直充
                        order_type:2
                        pay_channel:200
                        total_price:1000
                        clienttype:2
                        sub_gid:551
                        name:hupeng1
                        account:551%23002
                        goods_id:137
                        total_points:122000
                        ticket_code:123456
     * @return array
     *              code
     *              msg
     *              data:
     *                  order_num
     */
    public function create(Array $options){
        $url = $this->uri.strtolower(__FUNCTION__);
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }

    /**
     * 查看mc是否有未支付订单
     * @param array $options 同create接口
     * @return bool|mixed|string
     *              code
     *              msg
     *              data
     *                  list:未支付订单列表
     */
    public function getUnPayOrder(Array $options){
        $url = $this->uri.strtolower(__FUNCTION__);
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }

    /**
     * 将mc同种商品下的订单置为已过期
     * @param array $options 同create接口
     * @return bool|mixed|string
     *              code
     *              msg
     *              data
     *                  list:未支付订单列表
     */
    public function loseOrder(Array $options){
        $url = $this->uri.strtolower(__FUNCTION__);
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }

    /**
     * @param $uid
     * @param $order_num
     * @return array
     *              code:
     *              msg:
     *              data:
     *                  type:  0:状态异常，自行跳转 1:qrcode 2:url需要手动生成qrcode
     *                  order_info
     *                  mc_order_info
     *                  url
     * 获取订单支付码 或 支付链接
     */
    public function getPayCode($uid,$order_num){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'order_num'=>$order_num
        ];
        $params = array_merge($this->params,$data);
        return $this->get($url,$params);
    }

    /**
     * 获取订单是否已支付接口
     * @param $order_num
     * @return array
     *              code:
     *              msg:
     *              data
     *                  status:true|false
     */
    public function getOrderStatus($order_num,$uid){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'order_num'=>$order_num,
            'uid'=>$uid
        ];
        $params = array_merge($this->params,$data);
        return $this->get($url,$params);
    }

    /**
     * @param $uid
     * @param $order_num
     * @return array
     *             code:
     *              msg:
     *             data:
     *                 order_info: 订单基本信息
     *                 mc_order_info:  mc订单详细信息
     */
    public function getOrderInfo($uid,$order_num){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'order_num'=>$order_num
        ];
        $params = array_merge($this->params,$data);
        return $this->get($url,$params);
    }


    /**
     * @param $uid
     * @param $page
     * @param int $limit
     * @return array
     *              code
     *              msg
     *              data
     *                  total
     *                  page
     *                  limit
     *                  last
     *                  array
     *                      order_info
     *                      mc_order_info
     */
    public function getOrderList($uid,$page,$limit=20){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'page'=>$page,
            'limit'=>$limit
        ];
        $params = array_merge($this->params,$data);
        return $this->get($url,$params);
    }
}