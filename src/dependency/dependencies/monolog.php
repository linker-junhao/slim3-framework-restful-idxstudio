<?php
return function ($c) {
    $logSetting = $c->get('settings')['logger'];
    $logger = new \Monolog\Logger('access_logger');
    $mySQLLogPDO = new PDO($logSetting['mysql']['dsn'], $logSetting['mysql']['username'], $logSetting['mysql']['password']);

    $mySQLHandler = new \MySQLHandler\MySQLHandler($mySQLLogPDO, 'table_access_log', array('url', 'http_status', 'ip_addr', 'request_body'), \Monolog\Logger::DEBUG);
    $logger->pushHandler($mySQLHandler);
    return array(
        'access_logger' => $logger
    );
};