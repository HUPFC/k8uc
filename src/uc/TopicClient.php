<?php
namespace hupfc\k8uc\src\uc;

use hupfc\k8uc\src\Config;
use hupfc\k8uc\src\uc\CurlAbstract;

class TopicClient extends CurlAbstract {
    protected static $self;
    /**
     * @return TopicClient
     * 用于静态方式 单例方式调用类
     */
    public static function self()
    {
        if (self::$self && self::$self instanceof self) {
            return self::$self;
        }
        self::$self = new self();
        self::$self->uri = Config::$domain['uc']['forum'].'/topic/';
        return self::$self;
    }
    
    //动态展示
    public function topicList() {
        
    }
    
    //动态详情（评论列表）
    public function topicInfo() {
        
    }
    
    //动态发布
    public function topicRelease() {
        
    }
    
    //关注、删除关注用户
    public function userAttention() {
        
    }
    
    //评论发布
    public function commentRelease() {
        
    }
    
    //点赞、踩动态
    public function topicAgree() {
        
    }
    
}