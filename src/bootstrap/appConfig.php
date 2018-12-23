<?php

$config = [
    'settings' => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        'timeZone' => 'Asia/Shanghai',
        'APP_PATH' =>  __DIR__ . '/../',
        'logger' => [
            'name' => 'slim-app',
            'level' => Monolog\Logger::DEBUG,
            'path' => __DIR__ . '/../logs/app.log',
        ],
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'developing',
            'username' => 'developing',
            'password' => 'dev147258',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
        'slimRestfulSetting' => [
            'tableName' => 'table_token',
            'db' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'developing',
                'username' => 'developing',
                'password' => 'dev147258',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ],
        ],
        'twig' => [
            'cache' => false//__DIR__.'/../util/services/twig/cache'
        ]
    ],
];

return $config;