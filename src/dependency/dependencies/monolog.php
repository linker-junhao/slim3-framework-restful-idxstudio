<?php
return function($c) {
    $logSetting = $c->get('settings')['logger'];
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler($logSetting['path']);
    $logger->pushHandler($file_handler);
    return $logger;
};