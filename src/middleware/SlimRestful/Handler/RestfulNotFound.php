<?php

namespace Middleware\SlimRestful\Handler;

use Slim\Handlers\NotFound;

class RestfulNotFound extends NotFound
{
    /**
     * Return a response for application/json content not found
     *
     * @return string
     */
    protected function renderJsonNotFoundOutput()
    {
        return '{"message":"Not found"}';
    }

}
