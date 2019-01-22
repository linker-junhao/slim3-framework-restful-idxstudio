<?php
$container = $app->getContainer();

$container['logger'] = require('dependencies/monolog.php');

$container['db_cms'] = require('dependencies/eloquentCMSConnection.php');
$container['db_slimRestful'] = require('dependencies/eloquentSlimRestfulConnection.php');
$container['db_default'] = require('dependencies/eloquentDefaultConnection.php');

$container['view'] = require('dependencies/twig.php');

