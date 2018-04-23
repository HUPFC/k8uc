<?php

namespace hupfc\k8uc\src\hook;
use think\Request;

/**
 * 基于tp5.0.18
 * 系统行为扩展：页面静态化类
 */
class ReadHtmlCacheBehavior {
    protected $storage;
    /**
     * @var Request
     */
    protected $request;
    // 行为扩展的执行入口必须是run
    public function run(Request $request){
        // 开启静态缓存
        if('GET' === $request->method() && config('html_cache_on'))  {
            $this->request = $request;
            $cacheTime = $this->requireHtmlCache();
            if( false !== $cacheTime && $this->checkHTMLCache(HTML_FILE_NAME,$cacheTime)) { //静态页面有效
                // 读取静态页面输出
                include HTML_FILE_NAME;
                exit();
            }
        }
    }

    // 判断是否需要静态缓存
    static private function requireHtmlCache() {
        // 分析当前的静态规则
         $htmls = config('html_cache_rules'); // 读取静态规则
         if(!empty($htmls)) {
            $htmls = array_change_key_case($htmls);
            // 静态规则文件定义格式 actionName=>array('静态规则','缓存时间','附加规则')
            // 'read'=>array('{id},{name}',60,'md5') 必须保证静态规则的唯一性 和 可判断性
            // 检测静态规则
            $controllerName = strtolower(Request::instance()->controller());
            $actionName     = strtolower(Request::instance()->action());
            if(isset($htmls[$controllerName.':'.$actionName])) {
                $html   =   $htmls[$controllerName.':'.$actionName];   // 某个控制器的操作的静态规则
            }elseif(isset($htmls[$controllerName.':'])){// 某个控制器的静态规则
                $html   =   $htmls[$controllerName.':'];
            }elseif(isset($htmls[$actionName])){
                $html   =   $htmls[$actionName]; // 所有操作的静态规则
            }elseif(isset($htmls['*'])){
                $html   =   $htmls['*']; // 全局静态规则
            }
            if(!empty($html)) {
                // thinkphp5
                $method = request()->method();
                switch ($method) {
                    case 'GET':
                        $_GET = request()->param();
                        break;
                    case 'POST':
                        $_POST = request()->param();
                        break;
                    case 'REQUEST':
                        $_REQUEST = request()->param();
                        break;
                    case 'SERVER':
                        $_SERVER = request()->param();
                        break;
                    case 'SESSION':
                        $_SESSION = request()->param();
                        break;
                    case 'COOKIE':
                        $_COOKIE = request()->param();
                        break;
                    
                    default:
                        
                        break;
                }
                // 解读静态规则
                $rule   = is_array($html)?$html[0]:$html;
                // 以$_开头的系统变量
                $callback = function($match){ 
                    switch($match[1]){
                        case '_GET':        $var = $_GET[$match[2]]; break;
                        case '_POST':       $var = $_POST[$match[2]]; break;
                        case '_REQUEST':    $var = $_REQUEST[$match[2]]; break;
                        case '_SERVER':     $var = $_SERVER[$match[2]]; break;
                        case '_SESSION':    $var = $_SESSION[$match[2]]; break;
                        case '_COOKIE':     $var = $_COOKIE[$match[2]]; break;
                    }
                    return (count($match) == 4) ? $match[3]($var) : $var;
                };
                $rule     = preg_replace_callback('/{\$(_\w+)\.(\w+)(?:\|(\w+))?}/', $callback, $rule);
                // {ID|FUN} GET变量的简写
                $rule     = preg_replace_callback('/{(\w+)\|(\w+)}/', function($match){return $match[2]($_GET[$match[1]]);}, $rule);
                $rule     = preg_replace_callback('/{(\w+)}/', function($match){return $_GET[$match[1]];}, $rule);
                // 特殊系统变量
                $rule   = str_ireplace(
                    array('{:controller}','{:action}','{:module}'),
                    array(Request::instance()->controller(),Request::instance()->action(),Request::instance()->module()),
                    $rule);
                // {|FUN} 单独使用函数
                $rule  = preg_replace_callback('/{|(\w+)}/', function($match){return $match[1]();},$rule);
                // $cacheTime = config('html_cache_time') ?? '.html';//php7
                $cacheTime = config('html_cache_time');
                $cacheTime = $cacheTime ? $cacheTime: 60;
                if(is_array($html)){
                    if(!empty($html[2])) $rule    =   $html[2]($rule); // 应用附加函数
                    $cacheTime  =   isset($html[1])?$html[1]:$cacheTime; // 缓存有效期
                }else{
                    $cacheTime  =   $cacheTime;
                }
                
                // 当前缓存文件
                // $html_file_suffix = config('html_file_suffix') ?? '.html';//php7
                $html_file_suffix = config('html_file_suffix');
                $html_file_suffix = $html_file_suffix ? $html_file_suffix: '.html';

                //$rule = Request::instance()->module().'/'.Request::instance()->controller().'/'.Request::instance()->action().'/'.$rule;

                define('HTML_FILE_NAME',RUNTIME_PATH . $rule.$html_file_suffix);
                return $cacheTime;
            }
        }
        // 无需缓存
        return false;
    }

    /**
     * 检查静态HTML文件是否有效
     * 如果无效需要重新更新
     * @access public
     * @param string $cacheFile  静态文件名
     * @param integer $cacheTime  缓存有效期
     * @return boolean
     */
    static public function checkHTMLCache($cacheFile='',$cacheTime='') {

        if (ENV == 'prod' && true == config('app_debug')) {
            //生产环境下 debug模式不走静态缓存
            return false;
        }elseif (!is_file($cacheFile)) {
            return false;
        // }elseif (filemtime(\think\view()->parseTemplate()) > $this->storage()->read($cacheFile,'mtime')) {
        //     // 模板文件如果更新静态文件需要更新
        //     return false;
        } elseif (!is_numeric($cacheTime) && function_exists($cacheTime)){
            return $cacheTime($cacheFile);
        } elseif ($cacheTime != 0 && time() > filemtime($cacheFile)+$cacheTime) {
            // 文件是否在有效期
            return false;
        }
        //静态文件有效
        return true;
    }

}
