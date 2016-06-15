<?php
namespace Liaiyong\Subscriber\Common;

use Lay\Advance\Core\Encryptor;
use Lay\Advance\Core\Configuration;

//
class Security extends \Lay\Advance\Core\Security {
    public static function encryptString($string, $expires = 0, $key = 'oapcr') {
        $content = array (
                $string,
                empty($expires) ? 0 : 1,
                time() + $expires
        );
        $content = json_encode($content);
        return self::urlsafe_encrypt($content, $key);
    }
    public static function decryptString($string, $key = 'oapcr') {
        $ret = self::decryptStringInfo($string, $key);
        if (empty($ret)) {
            return false;
        } else if(count($ret) > 3 && $ret[2] && $ret[3] < time()){
            return false;
        } else {
            return $ret[1];
        }
    }
    public static function decryptStringInfo($string, $key = 'oapcr') {
        if (trim($string) == '') {
            return false;
        }

        $content = self::urlsafe_decrypt($string, $key);
        $ret = json_decode($content, true);
        if (empty($ret)) {
            return false;
        } else {
            return $ret;
        }
    }
    /**
     * 生成一个sid
     * sid是一个字符串的加密字串。规则是"[XXX,userid,time]"。
     * 
     * @param long $userId            
     * @return string
     */
    public static function generateSid($uid, $expires = 0, $key = 'advance') {
        global $CFG;
        $key = Configuration::get('sid_encrypt_key', $key);
        $expires = empty($expires) ? Configuration::get('sid_encrypt_expires', 0) : $expires;
        //$key = empty($key) ? $CFG['sid_encrypt_key'] : $key;
        //$expires = empty($expires) ? (empty($CFG['sid_encrypt_expires']) ? 0 : $CFG['sid_encrypt_expires']) : $expires;
        return parent::generateSid($uid, $key, $expires);
    }
    /**
     * 从sid中获取UID。
     *
     * @param string $sid            
     * @return int | boolean 如果token不合法则返回false;
     */
    public static function getUidFromSid($sid, $key = '') {
        global $CFG;
        return parent::getUidFromSid($sid, empty($key) ? Configuration::get('sid_encrypt_key', 'advance') : $key);
    }
    /**
     * 从sid中获取信息。
     *
     * @param string $sid            
     * @return array | boolean 如果token不合法则返回false，否则返回array('XXX', 'userid', flag, time)。
     */
    public static function getInfoFromSid($sid, $key = '') {
        return parent::getInfoFromSid($sid, empty($key) ? Configuration::get('sid_encrypt_key', 'advance') : $key);
    }

     /**
     * 加密一个文件名
     * @param string $file
     * @return string
     */
    public static function encryptFileName($file) {
        return base64_encode(@mcrypt_encrypt(MCRYPT_3DES, Configuration::get('file_encrypt_key', 'advance'), $file, MCRYPT_MODE_CFB));
    }
    
    /**
     * 解密一个文件名
     * @param string $encrypt
     * @return string|false
     */
    public static function decryptFileName($encrypt) {
        if (trim($encrypt) == '') {
            return false;
        }

        return @mcrypt_decrypt(MCRYPT_3DES, Configuration::get('file_encrypt_key', 'advance'), base64_decode($encrypt), MCRYPT_MODE_CFB);
    }
}

// PHP END