<?php
namespace hupfc\k8uc\src\uc;

use hupfc\k8uc\src\Config;
use hupfc\k8uc\src\uc\CurlAbstract;

class CommentClient extends CurlAbstract {
    protected static $self;
    /**
     * @return CommentClient
     * 用于静态方式 单例方式调用类
     */
    public static function self()
    {
        if (self::$self && self::$self instanceof self) {
            return self::$self;
        }
        self::$self = new self();
        self::$self->uri = Config::$domain['uc']['forum'].'/comment/';
        return self::$self;
    }
    
    /**
     * 发起评论
     * @param int $uid 评论人id
     * @param int $gid 评论游戏id
     * @param int $star 评论星星等级
     * @param string $content 评论内容
     */
    public function initComment($star,$content,$uid,$gid) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'star'=>$star,'content'=>$content,'uid'=>$uid,'gid'=>$gid
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }
    
    /**
     * 回复评论
     * @param int $uid 回复人id
     * @param int $comment_id 评论id
     * @param string $reply_content 回复评论内容
     */
    public function replyComment($comment_id,$uid,$reply_content) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'comment_id'=>$comment_id,'uid'=>$uid,'reply_content'=>$reply_content
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }

    /**
     * 评论列表
     * @param int $gid 游戏id
     * @param int type 评价（1全部2好评3差评）
     */
    public function commentList($type,$limit,$page,$gid) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'type'=>$type,'limit'=>$limit,'page'=>$page,'gid'=>$gid
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }
    
    /**
     * 回复列表
     * @param int comment_id 评论id
     */
    public function replyCommentList($comment_id) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'comment_id'=>$comment_id
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }
    
    /**
     * 点赞，取消点赞接口
     * @param int $uid 当前点赞人id
     * @param int type 点赞(1点赞2取消点赞)
     * @param int comment_id 评论id
     */
    public function isAgree($type,$comment_id,$uid) {
        $url = $this->uri.strtolower(__FUNCTION__);
        $options = [
            'type'=>$type,'comment_id'=>$comment_id,'uid'=>$uid
        ];
        $this->params = array_merge($this->params,$options);
        return $this->get($url,$this->params);
    }
    
}