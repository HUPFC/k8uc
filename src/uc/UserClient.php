<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/2/28
 * Time: 13:54
 */

namespace app\common\service\ucopclient;



use hupfc\k8uc\src\Config;
use hupfc\k8uc\src\uc\CurlAbstract;

class UserClient extends CurlAbstract
{

    protected static $self;
    /**
     * @return UserClient
     * 用于静态方式 单例方式调用类
     */
    public static function self()
    {
        if (self::$self && self::$self instanceof self) {
            return self::$self;
        }
        self::$self = new self();
        self::$self->uri = Config::$domain['uc']['user'].'/user/';
        return self::$self;
    }

    public $uri;

    /**
     * uc.op.kuai8.com  /usercheck/checkusernameexists 接口
     * @param $username
     * @return bool|mixed|string
     */
    public function checkUserNameExists($username){
        $url = $this->uri.strtolower(__FUNCTION__);
        $this->params['username'] = $username;
        return $this->get($url,$this->params);
    }

    /**
     * uc.op.kuai8.com  /usercheck/checkemailexists 接口
     * @param $username
     * @return bool|mixed|string
     */
    public function checkEmailExists($email){
        $url = $this->uri.strtolower(__FUNCTION__);
        $this->params['email'] = $email;
        return $this->get($url,$this->params);
    }

    public function reg($username,$password,$email){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'username'=>$username,'password'=>$password,'email'=>$email
        ];
        $this->params = array_merge($this->params,$data);
        return $this->get($url,$this->params);
    }

    public function editPwd($uid,$oldpassword,$password,$ignoreoldpw=false){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'oldpassword'=>$oldpassword,
            'password'=>$password,
            'ignoreoldpw'=>$ignoreoldpw,
        ];
        $this->params = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    //type 0:uid 1:用户名 2:邮箱 3:手机 4:qq
    public function login($account,$password,$type,$ignorepw=0){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'account'=>$account,
            'password'=>$password,
            'type'=>$type,
            'ignorepw'=>$ignorepw
        ];
        $this->params = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    //type 0:uid 1:用户名 2:邮箱 3:手机 4:qq
    public function getInfo($uid){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid
        ];
        $this->params = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    public function editEmail($uid,$email){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'email'=>$email,
        ];
        $this->params = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    public function verifyEmail($uid,$email){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'email'=>$email,
        ];
        $this->params = array_merge($this->params,$data);
        return $this->get($url,$data);
    }
}