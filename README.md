# k8uc
k8 ucenter client
```
v2/uc  v2/k8 对应的是两个不同的项目
调用uc系列接口时
先实例化hupfc\k8uc\src\Config的配置
           setLogOptions
               setParams
               setDomain
```

```
hook是基于tp5.0.18的php页面静态化插件
一般通过钩子调用
调用前实例化以下配置

对应模块的config文件
    //'配置项'=>'配置值'
    'HTML_CACHE_ON' => true, // 开启静态缓存
    'HTML_CACHE_TIME' => 3600, // 全局静态缓存有效期（秒）
    'HTML_FILE_SUFFIX' => '.shtml', // 设置静态缓存文件后缀
    'HTML_CACHE_RULES' => array( // 定义静态缓存规则
        // // 定义格式1 数组方式
        //'静态地址' => array('静态规则', '有效期', '附加规则'),
        //1.任意控制器的任意操作都适用
/*        '*'=>array('{$_SERVER.REQUEST_URI|md5}'),
        //2.任意控制器的md5操作
        'md5'=>array('{:module}/{:controller}/{:action}_{id|md5}'),
        //3.Static控制器的所有操作
        'Static:'=>array('{:module}/{:controller}/{:action}',50),//第一个参数是构造的字符串，后面是缓存50秒
        //4.Hmtl控制器的md5操作
        'Html:md5'=>array('{:module}/{:controller}/{:action}'),*/
    )

对应模块的 tags配置
    //web模块静态化配置
    'module_init'=>[
        '\\hupfc\\k8uc\\src\\hook\\ReadHtmlCacheBehavior',
    ],
    'view_filter'=>[
        '\\hupfc\\k8uc\\src\\hook\\WriteHtmlCacheBehavior',
    ],
```
