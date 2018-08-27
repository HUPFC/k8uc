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
        self::$self->uri = Config::$domain['k8']['user'].'/user/';
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
        $data['username'] = $username;
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    /**
     * uc.op.kuai8.com  /usercheck/checkemailexists 接口
     * @param $username
     * @return bool|mixed|string
     */
    public function checkEmailExists($email){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data['email'] = $email;
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    /**
     * 检查手机号是否已被注册
     * @param $mobile
     * @return bool|mixed|string
     */
    public function checkMobileExists($mobile){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data['mobile'] = $mobile;
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    /**
     * 帐号注册接口
     * @param $username
     * @param $password
     * @param null $email
     * @return bool|mixed|string
     */
    public function reg($username,$password,$email=null){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'username'=>$username,'password'=>$password,'email'=>$email
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    /**
     * 修改密码接口
     * @param $uid
     * @param $oldpassword
     * @param $password
     * @param bool $ignoreoldpw
     * @return bool|mixed|string
     */
    public function editPwd($uid,$oldpassword,$password,$ignoreoldpw=false){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'oldpassword'=>$oldpassword,
            'password'=>$password,
            'ignoreoldpw'=>$ignoreoldpw,
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    //通过手机号获取用户信息 ,或用于 检查手机号是否已注册
    public function getUserInfoByMobile($mobile){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'account'=>$mobile,
            'password'=>null,
            'type'=>5,
            'ignorepw'=>true
        ];
        $data = array_merge($this->params,$data);
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
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    //type 0:uid 1:用户名 2:邮箱 3:手机 4:qq
    public function getInfo($uid){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    public function editEmail($uid,$email){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'email'=>$email,
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    public function editEmailV2($uid,$old_email,$new_email,$client_type = ''){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'old_email'=>$old_email,
            'new_email'=>$new_email,
            'client_type'=>$client_type
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    public function verifyEmail($uid,$email){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'email'=>$email,
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }

    public function updateUserDetail($uid,$nick=false,$head=false){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'nick'=>$nick,
            'head'=>$head,
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }
    
    public function editInfo($uid,$img_id,$head,$nick){
        $url = $this->uri.strtolower(__FUNCTION__);
        $data = [
            'uid'=>$uid,
            'img_id'=>$img_id,
            'nick'=>$nick,
            'head'=>$head,
        ];
        $data = array_merge($this->params,$data);
        return $this->get($url,$data);
    }
}