<?php
/**
 * Created by PhpStorm.
 * User: heng
 * Date: 2017/5/30
 * Time: 15:35
 */

return [
    'app_id' => 'wxe0ba8eb7b92481ee',
    'app_secret' => 'bf100e4cac89f1ce0ee30bfdb71d0b52',
    'shop_name' => '探小店',
    'login_url' => 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code',
    'access_token_url' => 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s',
    'pay_callback' => 'https://www.onegledog.cn/v1/pay/wxnotify',
];