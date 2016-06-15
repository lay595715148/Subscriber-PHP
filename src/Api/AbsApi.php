<?php
namespace Liaiyong\Subscriber\Api;

use Lay\Advance\Core\Configuration;
use Lay\Advance\Util\Logger;
use Lay\Advance\Util\Utility;
use Lay\Advance\Core\Errode;
use Lay\Advance\Common\RequestContext;

use Liaiyong\Subscriber\Api\ApiApp;
use Liaiyong\Subscriber\Api\ApiAction;
use Liaiyong\Subscriber\Api\Data\VResponse;
use Liaiyong\Subscriber\Common\Security;

use Respect\Validation\Validator;

abstract class AbsApi extends ApiAction {
    protected $uid;
    protected $sid;
    protected $log = '';
    protected $params = array();
    protected $max_num = 100;
    protected $def_num = 20;
    protected $def_offset = null;
    protected $def_sincer = '';
    protected $useragent = "WEBTOP_1.0";
    protected $latitude = 0.0;
    protected $longitude = 0.0;
    protected $language = 'zh_cn';
    protected $media = array();
    protected $is_multipart = false;
    public function onCreate() {
        // listen
        ApiApp::$_event->listen(get_class($this), ApiAction::E_VALIDATE, array($this, '_afterValidate'));
        // with new validation
        //Validator::with('\\Liaiyong\\Subscriber\\Api\\Rules\\');
        // 检测SID
        $this->sid = $this->initParam('sid');
        // 通过SID获取UID，验证UID是否存在
        $this->uid = Security::getUidFromSid($this->sid);
        // 检测语言
        $this->language = $this->initParam('_lang', array('default' => $this->language));
        // 检测UA
        $this->useragent = $this->initParam('_ua', array('default' => $this->useragent));
        // 检测纬度
        $this->latitude = $this->initParam('_lat', array('default' => $this->latitude));
        // 检测经度
        $this->longitude = $this->initParam('_lng', array('default' => $this->longitude));
        // 是否有文件上传
        $this->is_multipart = RequestContext::getRequestContext()->isMultipart();
        parent::onCreate();
    }
    public function _afterValidate($obj, $valid) {
        if(!empty($valid)) {
            $this->afterValidate();
        } else {
            $this->afterInvalidate();
        }
    }
    // 验证正确时在onGet,onPost...前执行
    protected function afterValidate() {

    }
    // 验证不正确时在onRender前执行
    protected function afterInvalidate() {

    }
    /**
     * 初始化参与数据，将需验证或过滤的参数数据存放到本地变量中
     */
    protected function initParam($key, $opts = array()) {
        $opts = empty($opts) && !is_array($opts) ? array() : $opts;
        if(array_key_exists('default', $opts)) {
            // 有默认值
            $this->params[$key] = $_REQUEST[$key] = isset($_REQUEST[$key]) ? $_REQUEST[$key] : $opts['default'];
        } else if(isset($_REQUEST[$key])) {
            // 存在
            $this->params[$key] = $_REQUEST[$key];
        }
        return isset($this->params[$key]) ? $this->params[$key] : null;
    }
    /**
     * will transform this: 
     *  array(1) { 
     *      ["upload"]=>array(2) { 
     *          ["name"]=>array(2) { 
     *              [0]=>string(9)"file0.txt" 
     *              [1]=>string(9)"file1.txt" 
     *          } 
     *          ["type"]=>array(2) { 
     *              [0]=>string(10)"text/plain" 
     *              [1]=>string(10)"text/html" 
     *          } 
     *      } 
     *  } 
     *  into: 
     *  array(1) { 
     *      ["upload"]=>array(2) { 
     *          [0]=>array(2) { 
     *              ["name"]=>string(9)"file0.txt" 
     *              ["type"]=>string(10)"text/plain" 
     *          }, 
     *          [1]=>array(2) { 
     *              ["name"]=>string(9)"file1.txt" 
     *              ["type"]=>string(10)"text/html" 
     *          } 
     *      } 
     *  } 
     */
    private function diverseArray($vector) { 
        $result = array(); 
        foreach($vector as $key1 => $value1) 
            foreach($value1 as $key2 => $value2) 
                $result[$key2][$key1] = $value2; 
        return $result; 
    }
    // 初始化上传文件，可设定默认值，同时将Errode注入进去
    protected function initMedia($key, $opts) {
        if($this->is_multipart) {
            // 先整个将$_FILE['_file']初始化至{$this->media}中
            if(empty($this->media) && !empty($_FILES['_file'])) {
                foreach ($this->diverseArray($_FILES['_file']) as $k => $info) {
                    $this->media[$k] = $info;
                }
            }
        }
        if(array_key_exists('default', $opts)) {
            // 有默认值
            $this->media[$key] = isset($this->media[$key]) ? $this->media[$key] : $opts['default'];
        }
        // 将Errode加入media中,在下一步validateFile时使用到
        if(!empty($this->media[$key])) {
            switch ($this->media[$key]["error"]) {
                case UPLOAD_ERR_OK :
                    $this->media[$key]["errode"] = false;
                    break;
                case UPLOAD_ERR_NO_FILE :
                    $this->media[$key]["errode"] = Errode::upload_err_no_file();
                    break;
                case UPLOAD_ERR_INI_SIZE :
                    $this->media[$key]["errode"] = Errode::upload_err_ini_size();
                    break;
                case UPLOAD_ERR_FORM_SIZE :
                    $this->media[$key]["errode"] = Errode::upload_err_form_size();
                    break;
                case UPLOAD_ERR_PARTIAL :
                    $this->media[$key]["errode"] = Errode::upload_err_partial();
                    break;
                case UPLOAD_ERR_NO_TMP_DIR :
                    $this->media[$key]["errode"] = Errode::upload_err_no_tmp_dir();
                    break;
                case UPLOAD_ERR_CANT_WRITE :
                    $this->media[$key]["errode"] = Errode::upload_err_cant_write();
                    break;
                case UPLOAD_ERR_EXTENSION :
                    $this->media[$key]["errode"] = Errode::upload_err_extension();
                    break;
                default :
                    $this->media[$key]["errode"] = Errode::unkown_upload_file_error();
                    break;
            }
        }
        return isset($this->media[$key]) ? $this->media[$key] : null;
    }
    /**
     * 验证不通过，不执行onGet,onPost等方法，需要跳过时请重写此方法
     */
    public function onValidate() {
        $ps = $this->params();
        if(!empty($ps)) {
            // 先获取请求参数并放入{$this->params}变量中
            foreach ($ps as $key => $opts) {
                $this->initParam($key, $opts);
            }
            // 后验证
            foreach ($ps as $key => $opts) {
                if(array_key_exists('validator', $opts)) {
                    if(!$this->validate($key, $opts['validator'])) {
                        $this->failure(Errode::invalid_param($key));
                        return false;
                    }
                } else if(array_key_exists('filter', $opts)) {
                    // TODO filter
                }
            }
        }
        $fs = $this->files();
        if(!empty($fs)) {
            // 先将请求中文件放入{$this->media}变量中
            foreach ($fs as $key => $opts) {
                $this->initMedia($key, $opts);
            }
            // 后验证文件的大小与类型等等
            foreach ($fs as $key => $opts) {
                if(array_key_exists('validator', $opts)) {
                    if(!$this->validateFile($key, $opts['validator'])) {
                        //$this->failure(Errode::invalid_file_size($key));
                        return false;
                    }
                }
            }
        }
        return true;
    }

    protected function validate($key, $vs) {
        $vs = empty($vs) && !is_array($vs) ? array() : $vs;
        foreach ($vs as $validator) {
            if($validator instanceof Validator) {
                if(!$validator->validate($this->params[$key])) {
                    //echo '<pre>';print_r($validator->reportError($key));exit;
                    return false;
                }
            }
        }
        return true;
    }
    protected function filter($key, $fs) {
        
    }

    // 参数验证数组
    protected function params() {
        // cid => clientId
        // uid => userid, username(有些时候)
        // sid => security id,加密后的uid
        // tid, token => oauth2 token,OAuth2认证后获取的令牌码 
        // since 
        // offset
        // num
        // ...
        return array();
    }
    // 分别检测尺寸大小、类型及一些其他设定错误
    protected function validateFile($key, $vs) {
        $vs = empty($vs) && !is_array($vs) ? array() : $vs;

        // 对整体进行验证，主要验证是否可为空
        if(array_key_exists('validator', $vs)) {
            foreach ($vs['validator'] as $validator) {
                if($validator instanceof Validator) {
                    if(!$validator->validate($this->media[$key])) {
                        $this->failure(Errode::invalid_upload_file($key));
                        return false;
                    }
                }
            }
        } else {
            // 初始化为空数组
            if(empty($this->media[$key])) {
                $this->media[$key] = array();
            }
        }
        // 验证条件里有"错误"，同时上传文件信息里也存在"错误"时
        if(array_key_exists('error', $vs) && array_key_exists('error', $this->media[$key])) {
            foreach ($vs['error'] as $validator) {
                if($validator instanceof Validator) {
                    if(!$validator->validate($this->media[$key]['error'])) {
                        $errode = $this->media[$key]['errode'];// 使用初始化上传文件时已经设定的Errode
                        $this->failure(empty($errode) ? Errode::unkown_upload_file_error($key) : $errode);
                        return false;
                    }
                }
            }
        }
        // 验证条件里有尺寸，同时上传文件信息里也存在尺寸时
        if(array_key_exists('size', $vs) && array_key_exists('size', $this->media[$key])) {
            foreach ($vs['size'] as $validator) {
                if($validator instanceof Validator) {
                    if(!$validator->validate($this->media[$key]['size'])) {
                        $this->failure(Errode::invalid_upload_file_size($key));
                        return false;
                    }
                }
            }
        }
        // 验证条件里有类型，同时上传文件信息里也存在类型时
        if(array_key_exists('type', $vs) && array_key_exists('type', $this->media[$key])) {
            foreach ($vs['type'] as $validator) {
                if($validator instanceof Validator) {
                    if(!$validator->validate(strtolower($this->media[$key]['type']))) {
                        $this->failure(Errode::invalid_upload_file_type($key));
                        return false;
                    }
                }
            }
        }
        return true;
    }
    // 文件上传时的一些验证条件
    protected function files() {
        /* 
        icon => array(
            'default' => array(
                'name' => ...
                'type' => ...
                'tmp_name' => ...
                'size' => ...
                'error' => ...
            )
            'validator' => array(
                'validator' => array(Validator),
                'size' => array(Validator),
                'size' => array(Validator),
                'error' => array(Validator)
            )
        )
        */
        return array();
    }

    // 设置默认since中的sincer值
    protected function setDefaultSincer($sincer = null) {
        $this->def_sincer = is_null($sincer) ? $this->def_sincer : $sincer;
    }
    // 设置默认offset值
    protected function setDefaultOffset($offset = null) {
        $this->def_offset = is_null($offset) ? $this->def_offset : $offset;
    }


    // 通用获取since参数
    protected function getSince() {
        return empty($_REQUEST['since']) ? '' : $_REQUEST['since'];
    }
    // 通用获取since参数的条件部分
    protected function getSincer() {
        $sDetail = $this->getSinceDetail();
        if(empty($sDetail)) {
            return false;
        } else {
            list($first, $offset, $remain) = $sDetail;
            return $first;
        }
    }
    // 通用获取since参数的剩余部分
    protected function getRemain() {
        $sDetail = $this->getSinceDetail();
        if(empty($sDetail)) {
            return false;
        } else {
            list($first, $offset, $remain) = $sDetail;
            return $remain;
        }
    }
    // 通用获取since参数明细
    protected function getSinceDetail() {
        $since = $this->getSince();
        if(empty($since)) {
            return false;
        } else {
            $pieces = explode('.', $since);
            $pieces = empty($pieces) ? array() : $pieces;
            $first = array_shift($pieces);
            $first = empty($first) ? '' : $first;
            $offset = array_pop($pieces);
            $offset = is_null($offset) ? $this->def_offset : intval($offset);
            $remain = empty($pieces) ? array() : $pieces;
            return array($first, $offset, $remain);
        }
    }
    // 通用生成since参数
    protected function genSince($sincer = null) {
        $sDetail = $this->getSinceDetail();
        list($offset, $num) = $this->getLimit();
        $this->def_sincer = is_null($sincer) ? $this->def_sincer : $sincer;

        if($sDetail) {
            list($first, $offset, $remain) = $sDetail;
        } else {
            list($first, $offset, $remain) = array(null, null, array());
        }
        if(empty($first) && is_null($offset) && isset($_REQUEST['offset'])) {
        // 如果不存在since,存在offset参数时since中不添加offset值
            $pieces = array($this->def_sincer);
        } else if(empty($first) && is_null($offset)) {
        // 如果不存在since,不存在offset参数时since中添加offset值
            $pieces = array($this->def_sincer, $num);
        } else if(empty($first)){
        // 如果存在since且不为单时,since中添加offset值
            $pieces = array_merge(array($this->def_sincer), $remain, array($offset + $num));
        } else if(is_null($offset) && isset($_REQUEST['offset'])) {
        // 如果存在since且为单,存在offset参数时since中不添加offset值
            $pieces = array_merge(array($first));
        } else if(is_null($offset)) {
        // 如果存在since且为单,不存在offset参数时since中添加offset值
            $pieces = array_merge(array($first, $num));
        } else {
        // 如果存在since且不为单时,since中添加offset值
            $pieces = array_merge(array($first), $remain, array($offset + $num));
        }

        return implode('.', $pieces);
    }
    // 通用获取分页参数方法
    protected function getLimit() {
        $offset = empty($_REQUEST['offset']) ? 0 : intval($_REQUEST['offset']);
        $sDetail = $this->getSinceDetail($offset);
        $num = empty($_REQUEST['num']) ? $this->def_num : intval($_REQUEST['num']);
        // since中的offset优先级高
        if(empty($sDetail)) {
            if($offset < 0) {
                $offset = 0;
            }
        } else {
            list($first, $offset, $remain) = $sDetail;
            $offset = empty($offset) ? 0 : $offset;
        }
        if($num > $this->max_num) {
            $num = $this->max_num;
        }
        return array($offset, $num);
    }
    // 通用获取分页参数中的num值
    protected function getNum() {
        list($offset, $num) = $this->getLimit();
        return $num;
    }
    // 通用获取分页参数中的offset值
    protected function getOffset() {
        list($offset, $num) = $this->getLimit();
        return $offset;
    }
    // 通用生成hasNext参数
    protected function genHasNext($total) {
        list($offset, $num) = $this->getLimit();
        return Utility::hasNext($total, $offset, $num);
    }
    // 通用获取排序参数
    protected function getOrder() {
        return empty($_REQUEST['sort']) ? 0 : intval($_REQUEST['sort']);
    }
    // 通用获取排序参数明细
    protected function getOrderDetail($available = array()) {
        $sort = $this->getOrder();
        $keys = array();
        // 组织有效的keys
        if(is_array($available) && Utility::isAssocArray($available)) {
            foreach ($available as $key => $desc) {
                $keys[$key] = $this->detectDesc($desc);
            }
        } elseif (is_array($available)) {
            foreach ($available as $key) {
                $keys[$key] = $this->detectDesc();
            }
        }
        // get sort keys with desc or asc
        if(empty($sort) || empty($keys)) {
            return $keys;
        } else {
            $sorts = array();
            $pieces = explode(',', $sort);
            foreach ($pieces as $piece) {
                list($name, $desc) = array_merge(explode('.', $piece), array(false));
                // 在有效的keys中
                if($name && array_key_exists($name, $keys)) {
                    // false 时使用默认值
                    $desc = $desc === false ? $keys[$name] : $desc;
                    $sorts[$name] = $this->detectDesc($desc);
                }
            }
            // 返回
            return $sorts;
        }
    }


    // 转换排序正反（DESC，ASC）
    protected function detectDesc($desc = 'ASC') {
        $desc = empty($desc) ? 'ASC' : strval($desc);
        $desc = strtoupper($desc);
        switch ($desc) {
            case 'DESC':
            case '1':
                $desc = 'DESC';
                break;
            default:
                $desc = 'ASC';
                break;
        }
        return $desc;
    }

    // overide
    public function onRender() {
        $this->vresponse = empty($this->vresponse) ? new VResponse() : $this->vresponse;
        $this->template->distinct();// clean template vars
        $this->template->push($this->vresponse->toStandard());
        parent::onRender();
    }
}