<?php
namespace Liaiyong\Subscriber\Api;

use Lay\Advance\Core\App;
use Lay\Advance\Util\Logger;
use Lay\Advance\Http\Request;
use Lay\Advance\Core\Configuration;
use Lay\Advance\Core\Error;
use Lay\Advance\Core\Errode;

use Liaiyong\Subscriber\Api\Error\Trustee;

use Exception;

class ApiApp extends App {
    /**
     * App初始化
     * 
     * @return void
     */
    public function initialize() {
        // init trustee
        self::$_trustee = Trustee::getInstance();
        // init config
        $this->initConfig();
    }
    // init particular config
    protected function initConfig() {
        $path = self::$_rootpath;
        $env = self::get('env', 'test');
        $configfile = $path . '/config/api/main.' . $env . '.php';
        if(file_exists($configfile)) {
            Configuration::configure($configfile);
            // reload config cache
            Configuration::loadCache();
        }
    }
    // @Override detect classname
    protected function detect($webpath, $prefix = '\\Liaiyong\\Subscriber\\Api\\') {
        $wwwpath = realpath(self::$_docpath);
        return parent::detect($wwwpath, $prefix);
    }
    // @Override before run Action
    protected function before() {
		try {
            if(!empty($this->classname) && class_exists($this->classname)) {
                parent::before();
            }
        } catch(\Exception $err) {
            throw new Error(Errode::api_not_exists($this->apiname), 0, $err);
        }
    }
}

// PHP END