<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/3/20
 * Time: 11:35
 */

namespace hupfc\k8uc\src\v2\k8\user;



use hupfc\k8uc\src\Config;
use hupfc\k8uc\src\CurlAbstract;

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
        $this->uri = Config::$domain['k8']['user'].'/mobile/';
    }


    /**
     * 发送手机验证码
     * @param $mac
     * @param $mobile
     * @param $signame SIGNAME的key
     * @param $templatecode TEMPLATE_CODE的key
     * @return bool|mixed|string
     *     CONST SIGNAME =[
            'test'=>'阿里云短信测试专用',
            'mc'=>'快吧我的世界盒子',
            'kop'=>'快吧联机大厅',
            'kzs'=>'快吧手游盒子'
            ];
            CONST TEMPLATE_CODE = [
            'reg'=>'SMS_130415004',
            'login'=>'SMS_130415005',
            'mobile_valible'=>'SMS_130415006',
            ];
     */
    public function send($mac,$mobile,$signame,$templatecode){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'mac'=>$mac,'mobile'=>$mobile,'signame'=>$signame,'templatecode'=>$templatecode
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }
    
    public function checkCode($code,$mobile,$signame,$templatecode) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'code'=>$code,'mobile'=>$mobile,'signame'=>$signame,'templatecode'=>$templatecode
        ];
        $params = array_merge($this->params,$options);
        return $this->get($url,$params);
    }
}