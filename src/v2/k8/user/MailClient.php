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

class MailClient extends CurlAbstract
{

    protected static $self;
    /**
     * @return MailClient
     * 用于静态方式 单例方式调用类
     */
    public static function self()
    {
        if (self::$self && self::$self instanceof self) {
            return self::$self;
        }
        self::$self = new self();
        self::$self->uri = Config::$domain['k8']['user'].'/mail/';
        return self::$self;
    }

    public $uri;

    /**
     * @param array $options
     *                  uid:用户id
     *                  username:用户名
     *                  email:邮箱
     *                  type:邮件类型 1:找回密码 2:注册 3:认证邮箱 4:解绑邮箱
     *                  subject:邮件标题
     *                  message:邮件内容
     *                  expire:过期时间
     * @return bool|mixed|string
     */
    public function send(Array $options){
        $url = $this->uri.strtolower(__FUNCTION__);
        $this->params = array_merge($this->params,$options);
        $post['message'] = $this->params['message'];
        unset($this->params['message']);
        $url = $url.'?'.http_build_query($this->params);
        return $this->post($url,$post);
    }

    
}