<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/2/28
 * Time: 13:54
 */

namespace hupfc\k8uc\src\v2\uc\upload;



use hupfc\k8uc\src\Config;
use hupfc\k8uc\src\CurlAbstract;

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
        self::$self->uri = Config::$domain['uc']['upload'].'/img/';
        return self::$self;
    }

    public $uri;

    public function checkMd5($md5){
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'md5'=>$md5,
        ];
        $params = array_merge($this->params,$options);
        return $this->post($url,$params);
    }

    /**
     * 通过curl 模拟发送文件
     * @param array $data
     */
    public function upload($data){

        $url = $this->uri . strtolower(__FUNCTION__);
        $curlFiles=[];
        foreach ($data as $key=>$value){
            $curlFiles[$key]=new \CURLFile($value);
        }
        $dataTotal=$curlFiles;
//        echo (json_encode($dataTotal));die;
        //初始化curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataTotal);
        $response = curl_exec($ch);
        //获取curl相关信息
//         $info=curl_getinfo($ch);
        curl_close($ch);
        //容错机制
        if ($response === false){
            return curl_errno($ch);
        }
        return $response;
    }

}