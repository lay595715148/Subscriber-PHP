<?php
global $CFG;
$CFG['error'][404] = '文件未找到';
$CFG['error'][500] = '服务器内部错误';
//locales
$CFG['error'][310000] = '应用不存在';
//
$CFG['error'][800404] = '接口“%s”不存在';
$CFG['error'][800500] = '服务器内部错误';
// have some other vars
$CFG['error'][900000] = '无效参数“%s”';
$CFG['error'][999999] = '未知错误“%s”';

return $CFG;

// PHP END