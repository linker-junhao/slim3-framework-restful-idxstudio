<?php
$container = $app->getContainer();

$container['logger'] = require('dependencies/monolog.php');

$container['db'] = require('dependencies/eloquent.php');

$container['view'] = require('dependencies/twig.php');
