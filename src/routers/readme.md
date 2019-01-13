# 路由pattern规则
## 文件
### 命名
* 首写小写驼峰写法
### 划分
1. 同一个业务使用一个文件。
2. 使用`group` _统一第一级_ `pattern`。
3. 其中分为`api`和`web_page`两个`group`。
4. 每一级pattern仅描述一个事物，比如`reset_pass/apply`不能写作`reset_pass_apply`。
5. 路由patter使用下划线分割写法。
6. 清晰注释每个路由的业务功能。
``` PHP
// 统一第一级pattern
$app->group('/yiban', function () use ($app) {
    // api group
    $app->group('/api', function () use ($app) {

    });
    // web_page group
    $app->group('/web_page', function () use ($app) {

    });
});
```


