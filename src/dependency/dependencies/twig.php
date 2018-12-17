<?php
/**
 * Created by PhpStorm.
 * User: Linker
 * Date: 2018/12/13
 * Time: 15:24
 */

// Register component on container
return function ($container) {
    $view = new \Slim\Views\Twig(__DIR__.'/../services/twig/views', $container->get('settings')['twig']);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    return $view;
};