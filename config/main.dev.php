<?php
/**
 * 配置选项 
 * @category  
 * @package   
 * @author    liaiyong <liaiyong@dcux.com>
 * @version   1.0 
 * @copyright 2005-2016 dcux Inc.
 * @link      http://www.dcux.com
 * 
 */
global $CFG;
// 活动默认图标
$CFG['activity_default_icons'] = array(1000081, 1000082, 1000083, 1000084, 1000085);
// 默认经纬度，上海华东理工大学，lat:纬度，lng:经度
$CFG['location_default_lat_lng'] = array(31.149233, 121.433276);
// 运营号UID
$CFG['operation_uid'] = 1;
// 运营号UID
$CFG['notification_uid'] = 1;
// WEB URL主地址
$CFG['web_base_url'] = 'http://oapcr.project.dcux.com/';
// App URL主地址
$CFG['app_base_url'] = 'http://app.oapcr.project.dcux.com/test';
// API URL主地址
$CFG['api_base_url'] = 'http://api.oapcr.project.dcux.com/';
// CMS URL主地址
$CFG['cms_base_url'] = 'http://cms.oapcr.project.dcux.com/';
// SFC URL主地址
$CFG['sfc_base_url'] = 'http://sfc.oapcr.project.dcux.com/';
// SFC BASE FILE PATH
$CFG['sfc_base_path'] = 'C:/projects/OAPCR/sfc/';
// picture BASE FILE PATH
$CFG['picture_save_path'] = '//192.168.0.19/dcux_data/pic/';
// picture SFC URL主地址
$CFG['picture_sfc_base_url'] = 'http://192.168.0.19:8813/pic/';
// 默认事项提前提醒时间
$CFG['event_default_ahead_time'] = 5;// 5分钟
// 个人默认设置项
$CFG['user_default_setting'] = array('image_load_only_wifi' => '1', 'open_push' => '1', 'open_course_notify' => '1', 'open_activity_notify' => '1', 'open_private_notify' => '1');
// 用户添加时默认性别
$CFG['user_default_gender'] = '男';
// 用户默认兴趣选择项
$CFG['user_default_interest'] = array('讲座');
// 一天的节次时间
$CFG['current_section'] = array(array("8:00","8:45"),array("8:55","9:40"),array("9:55","10:40"),array("10:50","11:35"),array("13:30","14:15"),array("14:25","15:10"),array("15:25","16:10"),array("16:20","17:05"),array("18:00","18:45"),array("18:55","19:40"),array("19:55","20: 40"),array("20:50","21:35"));

$CFG['sfc_cache']['js']['open'] = false;
$CFG['sfc_cache']['js']['minimize'] = false;

//mysql base config
$CFG['mysql_host'] = '192.168.0.22';
$CFG['mysql_port'] = 3306;
$CFG['mysql_name'] = 'root';
$CFG['mysql_password'] = 'dcuxpasswd';
$CFG['mysql_database'] = 'oapcr';
$CFG['mysql_showsql'] = true;

// other alterable mysql config
$CFG['mysql']['default']['host'] = $CFG['mysql_host'];
$CFG['mysql']['default']['port'] = $CFG['mysql_port'];
$CFG['mysql']['default']['name'] = $CFG['mysql_name'];
$CFG['mysql']['default']['password'] = $CFG['mysql_password'];
$CFG['mysql']['default']['database'] = $CFG['mysql_database'];
$CFG['mysql']['default']['showsql'] = $CFG['mysql_showsql'];
$CFG['mysql']['session']['host'] = $CFG['mysql_host'];//session in mysql
$CFG['mysql']['session']['port'] = $CFG['mysql_port'];
$CFG['mysql']['session']['name'] = $CFG['mysql_name'];
$CFG['mysql']['session']['password'] = $CFG['mysql_password'];
$CFG['mysql']['session']['database'] = $CFG['mysql_database'];
$CFG['mysql']['session']['showsql'] = $CFG['mysql_showsql'];
$CFG['mysql']['identify']['host'] = $CFG['mysql_host'];//identify in mysql
$CFG['mysql']['identify']['port'] = $CFG['mysql_port'];
$CFG['mysql']['identify']['name'] = $CFG['mysql_name'];
$CFG['mysql']['identify']['password'] = $CFG['mysql_password'];
$CFG['mysql']['identify']['database'] = $CFG['mysql_database'];
$CFG['mysql']['identify']['showsql'] = $CFG['mysql_showsql'];
$CFG['mysql']['transfer']['host'] = $CFG['mysql_host'];//transfer in mysql
$CFG['mysql']['transfer']['port'] = $CFG['mysql_port'];
$CFG['mysql']['transfer']['name'] = $CFG['mysql_name'];
$CFG['mysql']['transfer']['password'] = $CFG['mysql_password'];
$CFG['mysql']['transfer']['database'] = 'transfer';
$CFG['mysql']['transfer']['showsql'] = $CFG['mysql_showsql'];
// memcache
$CFG['memcache_default_lifetime'] = 86400;//设置memcache的过期时间
$CFG['memcache_host'] = '192.168.0.22';
$CFG['memcache_port'] = 11211;
$CFG['memcache_show'] = true;
$CFG['memcache']['default']['host'] = $CFG['memcache_host'];
$CFG['memcache']['default']['port'] = $CFG['memcache_port'];
$CFG['memcache']['default']['show'] = $CFG['memcache_show'];
// server config
$CFG['server']['register']['uri'] = 'text://0.0.0.0:1236';
$CFG['server']['gateway']['uri'] = 'Websocket://0.0.0.0:8843';
$CFG['server']['gateway']['name'] = 'SsoGateway';
$CFG['server']['gateway']['count'] = 2;
$CFG['server']['gateway']['start_port'] = 7000;
$CFG['server']['gateway']['register_address'] = '127.0.0.1:1236';
$CFG['server']['gateway']['ping_interval'] = 300;
$CFG['server']['gateway']['ping_data'] = array('cmd'=>'ping');
$CFG['server']['business_worker']['name'] = 'SsoBusinessWorker';
$CFG['server']['business_worker']['count'] = 2;
$CFG['server']['business_worker']['register_address'] = '127.0.0.1:1236';
$CFG['server']['internal_gateway']['uri'] = 'Text://0.0.0.0:8842';
$CFG['server']['internal_gateway']['name'] = 'SsoInternalGateway';
$CFG['server']['internal_gateway']['start_port'] = 7800;
$CFG['server']['internal_gateway']['register_address'] = '127.0.0.1:1236';
// qrlogin code
$CFG['qrlogin_code_lifetime'] = 300;// 300秒过期时间
// sid key
$CFG['sid_encrypt_key'] = 'key_for_sid';
$CFG['sid_encrypt_expires'] = 86400 * 90;
// 限定用记只能绑定一个WebSocket客户端
$CFG['server_bind_unique'] = true;
// server key
$CFG['server_qrlogin_key'] = '123';
//$CFG['server_qrlogin_expires'] = 300;// 30秒过期时间
$CFG['server_internal_gateway'] = 'tcp://192.168.0.22:8842';// 内部服务地址及端口
// api qrlogin key
$CFG['api_qrlogin_key'] = '456';
// 扫码登录API地址
$CFG['api_qrlogin_url'] = 'http://api.oapcr.project.dcux.com/v0/qrlogin/scan';
// 扫码登录中二维码图片主地址
$CFG['qr_qrlogin_url'] = 'http://sfc.oapcr.project.dcux.com/cache/qr/qrlogin.png';
// 事项签到加密key
$CFG['event_qrcheckin_key'] = '789';
// 事项签到API地址
$CFG['event_qrcheckin_url'] = 'http://api.oapcr.project.dcux.com/v0/event/checkin';
// 扫码签到中二维码图片主地址
$CFG['qr_qrcheckin_url'] = 'http://sfc.oapcr.project.dcux.com/cache/qr/qrcheckin.png';
// 设置签到二维码过期时间
$CFG['qrcheckin_encrypt_expires'] = 600;

//mobile clients
$CFG['super_client_id'] = array("AndroidSDK");

// 普通图片，裁剪、缩放比例
$CFG['image_thumbnail_options'] = array(
	// 以宽度等比缩放
	array(16), array(32), array(48), array(64), array(72), array(96), array(100), array(128), array(150), array(200), array(320), array(400), array(480), array(512), array(540)/*, array(600)*/, array(640)/*, array(720), array(800), array(960)*/, array(1080),
	// 等宽高，缩放后再裁剪
	array(29, 29), array(40, 40), array(48, 48), array(58, 58), array(72, 72), array(76, 76), array(80, 80), array(87, 87), array(96, 96), array(120, 120), array(128, 128), array(144, 144), array(152, 152), array(180, 180), array(256, 256), array(512, 512)
);

//用户可创建群组最大数量
$CFG['count_group'] = 5;

// 微信公众号服务器接入TOKEN
$CFG['weixin_connect_token'] = 'b8cd54d2cf3d30f1fca41a6a1303d42b';
// 微信公众号开发者AppID（应用ID）
$CFG['weixin_mp_appid'] = 'wxa35298c9677b5076';
// 微信公众号开发者AppID（应用ID）
$CFG['weixin_mp_appsecret'] = 'b52c6cf1b0ca7b4beafffe0d5600a278';
// app version
include __DIR__ . '/app/version.php';
// language
include __DIR__ . '/lang/' . $CFG['language'] . '.php';
// error
include __DIR__ . '/error/error.php';//defines
include __DIR__ . '/error/error.' . $CFG['language'] . '.php';//languages
// 
return $CFG;

// PHP END