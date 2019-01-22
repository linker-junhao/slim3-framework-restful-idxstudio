<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/19
 * Time : 17:51
 */

namespace App\Http\Controllers;


use Slim\Http\Request;
use Slim\Http\Response;

interface ApiControllerInterface
{
    public function dataCollection(Request $request, Response $response, array $args);

    public function dataAppend(Request $request, Response $response, array $args);

    public function dataModify(Request $request, Response $response, array $args);

    public function dataDelete(Request $request, Response $response, array $args);
}