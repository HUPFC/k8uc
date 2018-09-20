<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/4/9
 * Time: 9:48
 */

namespace hupfc\k8uc\src;

abstract class CurlAbstract
{
    public $params;//参数
    public $curl;
    public $response;


    public function __construct()
    {
        require_once __DIR__.'/../lib/curl/curl.php';
        $this->curl = new \Curl();
        $this->curl->options = [
            'CURLOPT_TIMEOUT'=>15,//15秒超时
            'CURLOPT_CONNECTTIMEOUT'=>5,//tcp链接等待时间
        ];

        $this->params = Config::$params;
        if($this->params['userip'] == 'test'){
            throw new \Exception('请初始化配置');
        }
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
        Log::self()->info("[CURL][POST][START][{$url}][".substr(json_encode($params,JSON_UNESCAPED_UNICODE),0,512)."]");
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

    /**
     * @param $url
     * @param $files
     * @return mixed
     * @throws \Exception
     * 图片上传
     */
    protected function postImage($url,$files){
        Log::self()->info("[CURL][postImage][START][{$url}][".json_encode($files,JSON_UNESCAPED_UNICODE)."]");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $files);
        $response = curl_exec($ch);
        if ($response === false){
            Log::self()->error("[CURL][postImage][FAILED][error:".curl_error($ch)."]");
            throw new \Exception(curl_error($ch));
        }
        curl_close($ch);
        $array = json_decode($response,true);
        if(!$array){
            Log::self()->error("[CURL][postImage][FAILED][error:".$response."]");
            throw new \Exception($response);
        }
        Log::self()->info("[CURL][postImage][SUCCESS][result:".$response."]");
        return $array;
    }
}