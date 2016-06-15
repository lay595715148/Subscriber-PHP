<?php
// timezone
date_default_timezone_set('Asia/Shanghai');
// require autoload
require_once dirname(dirname(dirname(__DIR__))) . '/PHPLib/Autoloader.php';
// register classpath
Autoloader::register(dirname(dirname(__DIR__)) . '/src', 'Oapcr');
// start app
Dcux\Oapcr\Api\App::start(dirname(dirname(__DIR__)), dirname(__DIR__));

// PHP END