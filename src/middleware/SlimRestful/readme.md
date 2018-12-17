# 基于slim（v3）微框架中间件的授权管理

## 需要
MySQL数据库、eloquent ORM

## 配置
* 在数据库内创建数据表，创建语句如下
```sql
CREATE TABLE `table_token`  (
  `id` int(14) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `privilege` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `allowed_resource` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `expire_time` datetime(0) NOT NULL,
  `created_at` datetime(0) NOT NULL,
  `updated_at` timestamp(0) NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;
```

* 配置数据库链接，在slim容器的settings配置项内添加如下数组（按你的配置来更改）
``` PHP
'slimRestfulSetting' => [
    'tableName' => 'table_token',
    'db' => [
        'driver' => 'mysql',//数据库驱动
        'host' => 'localhost',//数据库服务器
        'database' => 'developing',//数据库名
        'username' => 'developing',//数据库用户名
        'password' => 'dev147258',//数据库用户名密码
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ],
],
```
## 使用
### 授权
* 在构建登陆模块时，验证了用户密码后，作如下操作来增加一个token权限
``` PHP
// 新建一个授权管理对象$authorizeToken，新建对象时须将slim的容器$container传入
$authorizeToken = new \Middleware\SlimRestful\SlimRestfulAuthToken($container);

//设置授权的用户id，后续私人资源鉴权必须
$authorizeToken->setUid('testuid');

//设置角色，角色资源鉴权必须
$authorizeToken->setRole('role');

//添加可访问的路由的pattern，与访问该路由（第一个参数）可使用的http 请求方法（第二个参数）
//添加第一个授权路由
$authorizeToken->addAllowedResource('pattern1',array('get','post'));

//添加第二个授权路由
$authorizeToken->addAllowedResource('pattern2',array('get','post',put));

//保存该授权
//该方法会返回该授权的信息，与tokenInformation()方法返回的信息相同
$authorizeToken->tokenAuthDone();

/如果要获取该已授权的信息，使用以下方法
$authorizeToken->tokenInformation();
```
* `tokenInformation()`方法
``` PHP
该方法返回一个关联数组
return array(
    'uid'   => uid,
    'token' => token,
    'privilege' => privilege,
    'role'      => role,
    'allowed_resource'  => allowed_resource,
    'expire_time'       => expire_time
);
```

### 鉴权
 需要鉴权的资源分为以下三种，其中个人私有资源和角色授权资源的鉴权在基本授权鉴权之后
> 1. 基本授权资源
> 2. 角色授权资源
> 3. 个人私有资源

* 验证基本授权

在需要基本授权验证的路由后添加`SlimRestfulBasicAuthCheck($container, 'Authorization')`中间件
第一个参数为slim container容器；第二个参数为请求携带token值的header字段名，该项选填，默认值为Authorization
```PHP
//基本授权，可以group添加，也可以单独为route添加
//route group添加中间件
$app->group('/basic', function () use ($app) {

})->add(new \Middleware\SlimRestful\SlimRestfulBasicAuthCheck($app->getContainer(), 'Authorization'));
//单个route添加
$app->get('/api', function ($request, $response) {
  return $response;
})->add(new \Middleware\SlimRestful\SlimRestfulBasicAuthCheck($app->getContainer()));
```

* 验证私人资源授权

在需要基本授权验证的路由后添加`SlimRestfulPrivateAuthCheck($container, $UIDArgumentName = 'uid')`中间件，第一个参数为slim
container 容器，第二个参数为路由路由pattern中表示用户id的参数名，默认值为'uid'。（**必须放在基本授权group内**）
```PHP
//基本授权group
$app->group('/basic', function () use ($app) {
    //可以group添加，也可以单独为route添加，放在基本授权group内
    //route group添加中间件
    $app->group('/basic/{uid}', function () use ($app) {

    })->add(new \Middleware\SlimRestful\SlimRestfulPrivateAuthCheck($app->getContainer(), 'uid'));
    //单个route添加
    $app->get('/api/{uid}/info', function ($request, $response) {
      return $response;
    })->add(new \Middleware\SlimRestful\SlimRestfulPrivateAuthCheck($app->getContainer(), 'uid'));
})->add(new \Middleware\SlimRestful\SlimRestfulBasicAuthCheck($app->getContainer()));
```

* 验证角色资源授权

在需要基本授权验证的路由后添加`SlimRestfulRoleAuthCheck($container, $roleArgumentName = 'role')`中间件，第一个参数为slim
container 容器，第二个参数为路由路由pattern中表示角色名的参数名，默认值为'role'。（**必须放在基本授权group内**）
```PHP
//基本授权group
$app->group('/basic', function () use ($app) {
    //可以group添加，也可以单独为route添加，放在基本授权group内
    //route group添加中间件
    $app->group('/basic/{role}', function () use ($app) {

    })->add(new \Middleware\SlimRestful\SlimRestfulRoleAuthCheck($app->getContainer(), 'role'));
    //单个route添加
    $app->get('/api/{role}/info', function ($request, $response) {
      return $response;
    })->add(new \Middleware\SlimRestful\SlimRestfulRoleAuthCheck($app->getContainer(), 'role'));
})->add(new \Middleware\SlimRestful\SlimRestfulBasicAuthCheck($app->getContainer()));
```

### 客户端请求
客户端请求时应在header内携带token，默认为Authorization字段。可以更改，同时后端基本授权验证
`SlimRestfulBasicAuthCheck($container, 'Authorization')`的第二个参数也应该做相应更改。


