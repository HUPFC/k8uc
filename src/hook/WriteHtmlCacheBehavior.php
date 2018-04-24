<?php

namespace hupfc\k8uc\src\hook;
/**
 * 系统行为扩展：静态缓存写入
 */
class WriteHtmlCacheBehavior
{
    // protected $storage;
    // public function action_begin(){
    public function run(&$content) {
        //2014-11-28 修改 如果有HTTP 4xx 3xx 5xx 头部，禁止存储
        //2014-12-1 修改 对注入的网址 防止生成，例如 /game/lst/SortType/hot/-e8-90-8c-e5-85-94-e7-88-b1-e6-b6-88-e9-99-a4/-e8-bf-9b-e5-87-bb-e7-9a-84-e9-83-a8-e8-90-bd/-e9-a3-8e-e4-ba-91-e5-a4-a9-e4-b8-8b/index.shtml
        if(strpos($content,'<error>1</error>') !== false){
            return ;
        }
        if (config('html_cache_on') && defined('HTML_FILE_NAME')
            && !preg_match('/Status.*[345]{1}\d{2}/i', implode(' ', headers_list()))
            && !preg_match('/(-[a-z0-9]{2}){3,}/i',HTML_FILE_NAME)) {
            $view_replace_str = config('view_replace_str');
            $arraySearch = array_keys($view_replace_str);
            $content = str_replace($arraySearch, $view_replace_str, $content);
            //静态文件写入
            $this->initStorage()->write(HTML_FILE_NAME, $content);
        }
    }
    // 初始化模板编译存储器
    private function initStorage() {
        $type = config('html_cache_compile_type');
        $type =$type ?$type : 'File';
        $class = false !== strpos($type, '\\') ? $type : '\\think\\template\\driver\\' . ucwords($type);
        return new $class();
    }
}
