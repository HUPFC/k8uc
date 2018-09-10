<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/4/9
 * Time: 9:53
 */

namespace hupfc\k8uc\src;

use Psr\Log\LogLevel;

class Log
{
    protected static $self;
    protected static $log;
    public static $save=true;
    protected static $options=[
        'map'=>[
            'error','warning','info','debug'
        ],
        'type'=>'file',
        'level'=>[],
        'file'=>[
            'path'=>'psr.log'
        ]
    ];

    /**
     * @return self
     * 用于静态方式 单例方式调用类
     */
    public static function self()
    {
        if (self::$self && self::$self instanceof self) {
            return self::$self;
        }
        self::$options = Config::$log_options;
        self::$self = new self();
        return self::$self;
    }

    /**
     * @return bool
     *  调用方运行
        register_shutdown_function(function(){
            Log::self()->save();
        });
     */
    public function save(){
        $config = Log::$options;
        $log = self::$log;
        $level = $config['level'];
        $depr = '';
        if(!$log){
            return false;
        }
        foreach ($log as $val){
            if(!$level){
                break;
            }
            if(!in_array($val['level'],$level)){
                continue;
            }
            $logLevel = $val['level'];
            $msg = $val['message'];
            $json = '';
            if($val['context']){
                $json = json_encode($val['context']);
            }
            $depr .= "[ $logLevel ] $msg  $json"."\r\n";
        }
        if(!$depr){
            return false;
        }

        // 获取基本信息
        if (isset($_SERVER['HTTP_HOST'])) {
            $current_uri = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        } else {
            $current_uri = "cmd:" . implode(' ', $_SERVER['argv']);
        }
        $depr = "\r\n---------------------------------------------------------------\r\n"."[ ".date('Y-m-d H:i:s')." ]".$current_uri."\r\n".$depr;
        $path = $config['file']['path'].'_'.date('Ymd');
        $f = fopen($path,'a+');
        $rs = fwrite($f,$depr,10240);
        fclose($f);
        self::$log = [];//重置log
        return true;
    }

    public function log($level,$message,Array $context){
        self::$log[] = [
            'level'=>$level,
            'message'=>$message,
            'context'=>$context,
        ];
    }

    public function info($message,Array $array=[]){
        $this->log(LogLevel::INFO,$message,$array);
    }

    public function error($message,Array $array=[]){
        $this->log(LogLevel::ERROR,$message,$array);
    }

    public function warn($message,Array $array=[]){
        $this->log(LogLevel::WARNING,$message,$array);
    }

    public function debug($message,Array $array=[]){
        $this->log(LogLevel::DEBUG,$message,$array);
    }

}