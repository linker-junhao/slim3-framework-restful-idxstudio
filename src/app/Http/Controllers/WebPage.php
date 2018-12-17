<?php
namespace App\Http\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class WebPage extends AbstractController
{
    public function appCenter(Request $request, Response $response, array $args)
    {
        $this->ci->view->render($response, 'appCenter.twig');
        return $response;
    }
}