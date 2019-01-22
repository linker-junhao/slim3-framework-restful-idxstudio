### 目录结构
#### /app
存放有控制器类、业务模型类、数据库对象关系映射
* /app/Http/controller
    1. 控制器类目录，所有类都继承自AbstractController类
    2. api控制器需要实现ApiControllerInterface类
* /app/Http/Models/ORM
    1. 数据库对象关系映射
    2. 所有的ORM类都继承自AbstractAppORM
    3. AbstractAppORM类继承自Eloquent的Illuminate\Database\Eloquent\Model类
    4. 新建ORM请查阅Eloquent使用手册
* /app/Http/Models/BM
    1. 这个目录存放的都是业务模型类
    2. 所有的类都继承自AbstractBM类
### 程序结构
用户-->路由-->控制器(controller)-->业务模型(BM)-->数据库对象关系映射(ORM)

# 工程构建注意事项
## git
### ignore
* nodejs库`node_modules`文件夹
* composer库`vendor`文件夹
* 工程配置信息文件夹，比如`.vscode`,`.idea`
* 密码配置相关文件夹
* 测试文件夹
* 日志文件夹