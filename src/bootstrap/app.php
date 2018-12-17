<?php
/**
 * get app config and set it
 */
$config = require_once('appConfig.php');

$app = new \Slim\App($config);

date_default_timezone_set($app->getContainer()->get('settings')['timeZone']);

return $app;