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
    public function topicList($limit,$page) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'limit'=>$limit,'page'=>$page
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }
    
    //动态发布
    public function topicRelease($imgs,$content,$uid) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'imgs'=>$imgs,'content'=>$content,'uid'=>$uid
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }
    
    //关注、取消关注用户（非本人发布的）
    public function userAttention($follow_id,$type,$follow_uid,$uid) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'follow_id'=>$follow_id,'type'=>$type,'follow_uid'=>$follow_uid,'uid'=>$uid
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }
    
    //点赞、踩动态
    public function topicAgree($agree_id,$type,$topic_id,$uid) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'agree_id'=>$agree_id,'type'=>$type,'topic_id'=>$topic_id,'uid'=>$uid
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }
    
    //举报动态
    public function topicBad($bad_content,$topic_id,$uid) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'bad_content'=>$bad_content,'topic_id'=>$topic_id,'uid'=>$uid
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }
    
    //分享动态
    public function topicShare($share_target,$topic_id,$uid) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'share_target'=>$share_target,'topic_id'=>$topic_id,'uid'=>$uid
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }
    
    //动态详情（评论列表）
    public function topicInfo($topic_id) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'topic_id'=>$topic_id
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }
    
    //评论发布
    public function commentRelease($topic_id,$reply_content,$uid) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'reply_content'=>$reply_content,'topic_id'=>$topic_id,'uid'=>$uid
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }
    
}