<?php
error_reporting(E_ALL ^ E_NOTICE);
// timezone
date_default_timezone_set('Asia/Shanghai');
// require autoload
/*require_once dirname(dirname(dirname(__DIR__))) . '/PHPLib/Autoloader.php';
// register classpath
Autoloader::register(dirname(dirname(__DIR__)) . '/src', 'Liaiyong\Subscriber');
// start app
Liaiyong\Subscriber\Api\ApiApp::start(dirname(dirname(__DIR__)), dirname(__DIR__));*/

require_once dirname(dirname(dirname(__DIR__))) . '/tao/src/Liaiyong/Tao/Yaf/BootstrapBuilder.php';

define('ROOT_PATH', dirname(dirname(__DIR__)));
define('TAO_PATH', dirname(ROOT_PATH) . '/tao');
define('LIB_PATH', dirname(ROOT_PATH) . '/PHPLib');
define('DOC_PATH', dirname(__DIR__));
define('CLASS_PATH', ROOT_PATH . '/src');
define('APP_PATH', ROOT_PATH . '/app');
define('APP_NAME', basename(DOC_PATH));

//Liaiyong\Tao\BootstrapBuilder::start('Liaiyong\Subscriber\Api\ApiApp', dirname(dirname(__DIR__)) . '/src;' . dirname(dirname(dirname(__DIR__))) . '/PHPLib', dirname(dirname(__DIR__)), dirname(__DIR__), 'Liaiyong\Subscriber');
$builder = new Liaiyong\Tao\Yaf\BootstrapBuilder('Liaiyong\Subscriber\Api\ApiApp');
$builder->setConfig(ROOT_PATH . '/config/application.ini')
	->setClassPath(CLASS_PATH)
	->setRootPath(ROOT_PATH)
	->setDocPath(DOC_PATH)
	->setIgnore('Liaiyong\Subscriber')
	->build();

// PHP END