<?php
/**
 * App版本配置选项 
 * @category  
 * @package   
 * @author    liaiyong <liaiyong@dcux.com>
 * @version   1.0 
 * @copyright 2005-2016 dcux Inc.
 * @link      http://www.dcux.com
 */
global $CFG;

//$CFG['VERSION']['keqian'][] = array();
// current version
$CFG['VERSION']['keqian'][] = array(
    'app_name' => '课前',
    'app_name_en' => 'BeforeClass',
    'version' => '0.2.9.8',
    'version_code' => 8,
    'app_url' => $CFG['app_base_url'] . '/keqian-v0.2.9.apk',
    'description' => '课前V0.2.9',
    'create_time' => '2016-05-23',
    'support_version' => 1
);
// old version
$CFG['VERSION']['keqian'][] = array(
    'app_name' => '课前',
    'app_name_en' => 'BeforeClass',
    'version' => '0.2.8.7',
    'version_code' => 7,
    'app_url' => $CFG['app_base_url'] . '/keqian-v0.2.8.apk',
    'description' => '课前V0.2.8',
    'create_time' => '2016-05-02',
    'support_version' => 1
);
$CFG['VERSION']['keqian'][] = array(
    'app_name' => '课前',
    'app_name_en' => 'BeforeClass',
    'version' => '0.2.7.6',
    'version_code' => 6,
    'app_url' => $CFG['app_base_url'] . '/keqian-v0.2.7.apk',
    'description' => '课前V0.2.7',
    'create_time' => '2016-04-29',
    'support_version' => 1
);
$CFG['VERSION']['keqian'][] = array(
    'app_name' => '课前',
    'app_name_en' => 'BeforeClass',
    'version' => '0.2.5.3',
    'version_code' => 3,
    'app_url' => $CFG['app_base_url'] . '/keqian-v0.2.5.apk',
    'description' => '课前V0.2.5',
    'create_time' => '2016-04-21',
    'support_version' => 1
);

return $CFG;
// PHP END