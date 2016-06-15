<?php
// timezone
date_default_timezone_set('Asia/Shanghai');
// require autoload
require_once dirname(dirname(dirname(__DIR__))) . '/PHPLib/Autoloader.php';
// register classpath
Autoloader::register(dirname(dirname(__DIR__)) . '/src', 'Liaiyong\Subscriber');
// start app
Liaiyong\Subscriber\Api\ApiApp::start(dirname(dirname(__DIR__)), dirname(__DIR__));

// PHP END