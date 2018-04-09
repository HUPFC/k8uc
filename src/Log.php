<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/4/9
 * Time: 9:53
 */

namespace hupfc\k8uc\src;


use Psr\Log\AbstractLogger;

class Log extends AbstractLogger
{
    protected static $self;
    protected static $log;
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

    public function save(){
        $config = Log::$options;
        $log = self::$log;
        $level = $config['level'];
        $depr = '';
        foreach ($log as $val){
            if(!$level){
                break;
            }
            if(!in_array($val['level'],$level)){
                continue;
            }
            $logLevel = $val['level'];
            $msg = $val['msg'];
            $json = json_encode($val['context']);
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
        $f = fopen($config['file']['path'],'a+');
        fwrite($f,$depr,10240);
        fclose($f);
        return true;
    }

    public function log($level,$message,Array $context){
        self::$log[] = [
            'level'=>$level,
            'message'=>$message,
            'context'=>$context,
        ];
    }
}