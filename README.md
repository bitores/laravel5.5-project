# 使用 Laravel 快速构建网站

### ![Laravel 5 Boilerplate](http://static.laravelacademy.org/wp-content/uploads/2015/10/2015-10-15_155026.jpg)

### **1、简介**

[Laravel](http://laravelacademy.org/tags/laravel) 5 [Boilerplate](http://laravelacademy.org/tags/boilerplate)是基于当前Laravel最新版本（Laravel [5.5](http://laravelacademy.org/tags/5-1).*）并集成Boilerplate的项目。

### **2、GitHub**

[https://github.com/rappasoft/laravel-5-boilerplate](https://github.com/rappasoft/laravel-5-boilerplate)

### **3、功能特性**

- 自定义访问控制系统（认证/用户/[角色](http://laravelacademy.org/tags/%e8%a7%92%e8%89%b2)/[权限](http://laravelacademy.org/tags/%e6%9d%83%e9%99%90)）
- 第三方登录（GitHub/Facebook/Twitter/Google）
- 通过邮箱验证用户
- 重新发送确认邮件
- 登录次数限制（登录失败情况下）
- 后台管理
  - 用户列表
  - 激活/冻结用户
  - 软删除&永久删除用户
  - 禁止用户
  - 重新发送确认邮件
  - 修改用户密码
  - 创建/管理角色
  - 创建/管理权限（暂时还没有）
  - 创建/管理权限组（暂时还没有）
  - 管理用户角色/权限
  - 权限依赖
- 默认响应式布局
- 前后端控制器
- 用户面板
- 使用 [Admin LTE](https://almsaeedstudio.com/)主题的管理员面板
- 命名空间路由
- 自带Form/HTML门面
- 默认表单转化为表单帮助方法
- 通过通用组件管理布局文件
- Laravel Elixir 3.0
- 使用Elixir编译CSS并自动将其置于HTML头部
- 使用Elixir编译JS并自动将其置于HTML尾部
- 帮助函数
- JavaScript/jQuery片段
- [Bootstrap 4（LESS/SASS）](http://www.getbootstrap.com/)
- [HTML5 Boilerplate v5.0](http://www.html5boilerplate.com/)
- [Font Awesome (LESS/SASS)](http://fortawesome.github.io/Font-Awesome/)
- 全局消息/异常处理
- 表单宏（状态和国家下拉框，可轻松扩展）
- [社会化登录认证集成](https://github.com/laravel/socialite)
- [Laracast生成器](https://github.com/laracasts/Laravel-5-Generators-Extended)
- [Stripe](http://stripe.com/)封装类
- [Active Menu](https://github.com/letrunghieu/active)
- [PHP转化为JavaScript](https://github.com/laracasts/PHP-Vars-To-Js-Transformer)
- [ARCANEDEV日志查看器](https://github.com/ARCANEDEV/LogViewer)
- 本地化，目前支持英语、意大利语、葡萄牙语（巴西）、俄语以及瑞典语等等
- 前后端语言选择菜单
- [头像](https://github.com/creativeorange/gravatar)
- 标准
  - 干净的控制器
  - Repository/Contract实现
  - 请求类
  - 事件/处理器
  - 整个应用分割成前端/后端
  - 处处本地化

### **4、安装**

```
composer install
npm install
创建.env文件（示例中已包含）
php artisan key:generate
php artisan migrate
在UserTableSeeder.php设置管理员信息
php artisan db:seed
npm install -g gulp
运行gulp或gulp watch
```

### **5、访问控制系统**

#### **配置文件**

```
/** Access使用Role模型创建正确的关联 */
access.role

/** Access使用的Roles表用于保存角色到数据库 */
access.roles_table

/** Access使用的Permission模型用于创建正确的关联 */
access.permission

/** Permissions table used by Access to save permissions to the database. */
access.permissions_table

/** Access使用的PermissionGroup模型用于创建权限组. */
access.group

/** Access使用的Permissions表用于保存权限到数据库 */
access.permissions_group_table

/** Access使用的permission_role表用于保存权限和角色之间的关系到数据库 */
access.permission_role_table

/** Access使用的permission_user表用于保存权限和用户之间的关系到数据库，该表仅用于那些只归属于特定用户而不是角色的权限 */
access.permission_user_table
/** 指定权限之间依赖关系的表，例如用户在拥有编辑权限之前必须有对后台的访问权限 */
access.permission_dependencies_table

/** Access使用的assigned_roles用于保存分配的角色到数据库 */
access.assigned_roles_table

/** 用户配置 */
access.users.default_per_page

/** 当用户在前台注册后分配的角色 */
access.users.default_role

/** 用户注册时是否需要邮箱确认 */
access.users.confirm_email

/** 用户邮箱是否可以在编辑用户信息页面被修改 */
access.users.change_email

/** 一个角色是否必须至少包含一个权限还是可以单独存在*/
access.roles.role_must_contain_permission
```

#### **应用路由中间件**

内置的路由中间件允许你通过角色或权限实现登录认证：

```
Route::group(['middleware' => 'access.routeNeedsPermission:view-backend', function()
{
     Route::group(['prefix' => 'access'], function ()
     {
         /* 用户管理 */
         Route::resource('users', 'Backend\Access\UserController');
     });
});
```

下面的中间件处理boilerplate：

- access.routeNeedsRole
- access.routeNeedsPermission

#### **创建自己的中间件**

如果你想要创建属于自己的中间件，可以使用如下方法：

```
/**
 * 通过名字判断用户是否拥有某个角色
 * @param string $name
 * @return bool
 */
Access::hasRole($role);

/**
 * 判断用户是否拥有某个角色数组，以及认证时是否全部包含才必须返回true
 * @param array $roles
 * @param boolean $needsAll
 * @return bool
 */
Access::hasRoles($roles, $needsAll);

/**
 * 通过名字判断用户是否拥有某个权限
 * 还有一个封装方法hasPermission这个传入参数一样
 * @param string $permission.
 * @return bool
 */
Access::can($permission);

/**
 * 判断权限数组以及是否所有权限都具备才能继续
 * 还有一个封装方法hasPermissions和此传入参数一样
 * @param array $permissions
 * @param boolean $needsAll
 * @return bool
 */
Access::canMultiple($permissions, $needsAll);

```

Access默认使用当前登录用户，你还可以：

```
$user->hasRole($role);
$user->hasRoles($roles, $needsAll);
$user->can($permission);
$user->canMultiple($permissions, $needsAll);
$user->hasPermission($permission); //Wrapper function for can()
$user->hasPermissions($permissions, $needsAll); //Wrapper function for canMultiple()

```

#### **Blade扩展**

可以定义一个blade扩展命令将访问控制应用到页面数据的显示与否：

```
@role
```

接收角色名称或ID

```
@role('User')
   只有认证用户有User角色才会显示这里的内容
@endauth

@role(1)
    只有认证用户有ID为1的角色才会显示这里的内容
@endauth

@roles

```

接收角色名称或ID数组

```
@roles(['Administrator', 'User'])
    只有认证用户拥有`Administrator`或`User`角色才会显示这里的内容
@endauth

@roles([1, 2])
    只有认证用户拥有ID为1或2的角色才会显示这里的内容
@endauth

@needsroles

```

接收角色或角色ID数组并且只有用户拥有提供的全部角色时才返回true

```
@needsroles(['Administrator', 'User'])
    只有认证用户拥有`Administrator`和`User`角色才会显示这里的内容
@endauth

@needsroles([1, 2])
    只有认证用户拥有ID为1和2的角色才会显示这里的内容
@endauth

@permission

```

接收单个权限名称或ID

```
@permission('view-backend')
    只有用户拥有`view-backend`权限时才会显示这里的内容
@endauth

@permission(1)
    只有用户拥有ID为1的权限时才会显示这里的内容
@endauth

@permissions

```

接收权限名称或ID数组

```
@permissions(['view-backend', 'view-some-content'])
    只有用户拥有`view-backend`或`view-some-content`权限时才会显示这里的内容
@endauth

@permissions([1, 2])
    只有用户拥有ID为1或2的权限时才会显示这里的内容
@endauth

@needspermissions

```

接收权限或权限ID数组并且用户拥有提供的全部权限时才返回true

```
@needspermissions(['view-backend', 'view-some-content'])
    只有用户拥有`view-backend`和`view-some-content`权限时才会显示这里的内容
@endauth

@needspermissions([1, 2])
    只有用户拥有ID为1和2的权限时才会显示这里的内容
@endauth

```

> 注意：你还可以使用@else用于if/else语句

如果你想要显示或隐藏特定区块，可以在布局文件中这样做：

```
@role('User')
    @section('special_content')
@endauth

@permission('can_view_this_content')
    @section('special_content')
@endauth

```

你还可以追加更多blade扩展命令到`App\Providers\AccessServiceProvider@registerBladeExtensions`。

### **6、权限依赖**

权限依赖允许你告诉系统某个权限基于一个或多个其它权限。

例如：如果用户有创建用户权限，那么还要具备查看后台和查看访问管理的权限，否则他们不能到达创建用户界面。因此我们说创建用户权限依赖于查看后台和查看访问管理权限。

你可以在每个权限依赖设置中指定该权限依赖于哪些其他权限。

### **7、社交媒体**

要配置社交媒体登录，添加你的凭证到`.env`文件。重定向必须遵循这个约定：`http://mysite.com/auth/login/SERVICE`。目前支持的社交媒体包括`github`, `facebook`, `twitter`, 和`google`，每一个的登录链接内置于`login.blade.php`。

如果你在本地locahost获取了`cURL error 60`错误，查看这些[指导说明](http://stackoverflow.com/questions/28635295/laravel-socialite-testing-on-localhost-ssl-certificate-issue)。

### **8、PHP转化为JavaScript**

PHP->JavaScript转换器已经包含在本项目中，配置文件是`config/javascript.php`。

默认情况下JavaScript变量绑定到前端布局文件`frontend/layouts/master.blade.php`，因此你可以在任何前端控制器绑定任何JavaScript方法。

如果你需要在前端和后端控制器都绑定变量，应该创建一个全局总布局文件，并且使用前端/后端布局文件作为其子文件。再然后可以在`javascript.bind_js_vars_to_this_view`配置选项指定当前布局。

`javascript()`帮助函数已经添加到全局因此你不再需要在控制器中引入其它文件，只需要像这样调用该方法：

```
javascript()->put([
    'test' => 'it works!'
]);
```

这是一个`FrontendController@index`的示例，并且可以在`frontend.index`视图文件中打印出来。

### **9、可能出现的问题及解决办法**

如果由于某种原因导致出错，试试下面的解决办法：

删除`composer.lock`文件

运行`dumpautoload`命令：

```
$ composer dumpautoload -o
```

如果上面的修复失败，并且命令行报错，错误信息指向`compiled.php`，则删除`storage/framework/compiled.php`文件。

如果上面的办法都没有奏效，那么只能给我们[报告错误](https://github.com/rappasoft/Laravel-5-Boilerplate/issues)了。

