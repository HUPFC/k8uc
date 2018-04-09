<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/4/9
 * Time: 9:48
 */

namespace hupfc\k8uc\src\uc;


use hupfc\k8uc\src\Config;

abstract class CurlAbstract
{
    public $params;//参数
    public $curl;
    public $response;
    

    public function __construct()
    {
        require_once '../../lib/curl/curl.php';
        $this->curl = new \Curl();
        $this->curl->options = [
            'CURLOPT_TIMEOUT'=>15,//15秒超时
            'CURLOPT_CONNECTTIMEOUT'=>5,//tcp链接等待时间
        ];

        $this->params = Config::$params;
    }

    /**
     * @param $url
     * @param $params
     * @param array $options
     * @return bool|mixed|string
     */
    protected function get($url,Array $params,$options=array()){
        Log::self()->info("[CURL][GET][START][".$url."?".http_build_query($params)."]");
        $rs = $this->curl->get($url,$params);
        if($this->curl->error()){
            Log::self()->error("[CURL][GET][FAILED][error:".$this->curl->error()."]");
            return false;
        }else{
            Log::self()->info("[CURL][GET][SUCCESS][result:".json_encode($rs,JSON_UNESCAPED_UNICODE)."]");
            $rs->body = json_decode($rs->body,true)?json_decode($rs->body,true):$rs->body;
            return $rs->body;
        }
    }

    /**
     * @param $url
     * @param $params
     * @param array $options
     * @return bool|mixed|string
     */
    protected function post($url,Array $params,$options=array()){
        Log::self()->info("[CURL][POST][START][{$url}]");
        $rs = $this->curl->post($url,$params);
        $this->response = $rs;
        if($this->curl->error()){
            Log::self()->error("[CURL][POST][FAILED][error:".$this->curl->error()."]");
            return false;
        }else{
            Log::self()->info("[CURL][POST][SUCCESS][result:".json_encode($rs,JSON_UNESCAPED_UNICODE)."]");
            $rs->body = json_decode($rs->body,true)?json_decode($rs->body,true):$rs->body;
            return $rs->body;
        }
    }
}