<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/4/9
 * Time: 10:51
 */

namespace hupfc\k8uc\src;


class Config
{
    public static $log_options=[
        'map'=>[
            'error','warning','info','debug'
        ],
        'type'=>'file',
        'level'=>[],
        'file'=>[
            'path'=>'psr.log'
        ]
    ];

    public static $params = [
        'userip'=>'test',//用户ip
        'clientip'=>'test',//客户端服务器ip
        'clienttype'=>0,//客户端业务类型 1:user.mc 2:联机平台
        'key' => '',//key 密钥
    ];

    public static $domain = [
        'mc'=>[

        ],
        'uc'=>[
            'user'=>'http_domain',
            'mc'=>'http_domain'
        ],
        'op'=>[

        ],
    ];

    public static function setLogOptions($options){
        self::$log_options = array_merge(self::$log_options,$options);
    }

    public static function setParams($params){
        self::$params = array_merge(self::$params,$params);
    }

    public static function setDomain($domain){
        self::$params = array_merge(self::$domain,$domain);
    }
}