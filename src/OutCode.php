<?php
/**
 * Created by PhpStorm.
 * User: hupeng
 * Date: 2018/3/8
 * Time: 15:23
 */

namespace hupfc\k8uc\src;

/**
 * Class OutCode
 * @package hupfc\k8uc\src
 * 错误码
 */
class OutCode
{

    //600 昵称，登录 用户 注册 信息
    CONST NICKNAME_EXIST = 601;//昵称被占用
    CONST NICKNAME_TOOMUCH = 602;//昵称太多
    CONST ACCOUNT_ERROR = 603;//帐号密码错误
    CONST ACCOUNT_UNFOUND = 604;//帐号不存在
    CONST PARAMS_ERROR = 605;//参数不符合规范
    CONST DB_ERROR = 606;//参数不符合规范
    CONST REQUEST_TOO_MUCH = 607;//请求次数过多
    CONST NICKNAME_NEED_CHECK=609; //该昵称还未绑定，但是需要验证
    CONST NICKNAME_NEED_CHECK_FAIL=610; //authme表验证失败，绑定昵称失败

    //订单相关
    CONST COUPONS_EXIST = 611;//商品不存在或者未发布
    CONST SERVER_UNPUBLISH = 612;//服务器未发布
    CONST ORDER_INSERT_ERROR = 613;//订单插入失败
    CONST ORDER_ROLL = 614;//订单插入失败 回滚
    CONST ORDER_UNPAY = 615;//订单未支付
    CONST ORDER_TIMEOUT=616;//订单已过期
    CONST ORDER_STATUS_ERROR=617;//订单状态异常
    CONST USER_EXIST = 618;//用户不存在
    CONST PAY_MONEY_LIMIT = 619;//购买金额限制

    //700 系统码
    CONST SYSTEM_UPDATE = 701;//系统维护
}