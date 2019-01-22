<?php
/**
 * Created by PhpStorm.
 * User : Linker
 * Email: linker-junhao@outlook.com
 * Date : 2019/1/13
 * Time : 22:43
 */

namespace IdxLib\Middleware\Logger;


use IdxLib\Middleware\SlimRestful\Util\SlimRestfulDatabase;
use IdxLib\Util\Network\Network;
use Psr\Container\ContainerInterface;

class AccessLogger
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * restful Middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface $response PSR7 response
     * @param  callable $next Next Middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $response = $next($request, $response);
        $statusCode = $response->getStatusCode();
        $clientIP = Network::getIP();
        $uri = $request->getUri();
        $requestURL = $uri->getScheme() . '://' . $uri->getHost() . ':' . $uri->getPort() . $uri->getPath();
        if (($query = $uri->getQuery()) != '') {
            $requestURL .= '?' . $query;
        }
        $parsedBody = $request->getParsedBody();
        if ($parsedBody == null) {
            $bodyJson = '{}';
        } else {
            $bodyJson = json_encode($parsedBody);
        }

        if ($statusCode == 500) {
            $this->container['logger']['access_logger']
                ->addError("服务器内部错误!", array('url' => $requestURL, 'http_status' => $statusCode, 'ip_addr' => $clientIP, 'request_body' => $bodyJson));
        } elseif ($statusCode == 403 || $statusCode == 401) {
            $this->container['logger']['access_logger']
                ->addWarning("未认证，未授权的访问!", array('url' => $requestURL, 'http_status' => $statusCode, 'ip_addr' => $clientIP, 'request_body' => $bodyJson));
        } elseif ($statusCode == 404) {
            $this->container['logger']['access_logger']
                ->addNotice("访问不存在的页面。", array('url' => $requestURL, 'http_status' => $statusCode, 'ip_addr' => $clientIP, 'request_body' => $bodyJson));
        } else {
            $this->container['logger']['access_logger']
                ->addInfo("正常操作", array('url' => $requestURL, 'http_status' => $statusCode, 'ip_addr' => $clientIP, 'request_body' => $bodyJson));
        }
        return $response;
    }
}