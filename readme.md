## 环境要求
* PHP >= 7.1
* composer 最新版
* MySQL >= 5.7.19

## 安装

```base
# 拉取代码
$ git clone https://coding.net/u/bukexue/p/bang-server/git
  
# 网络不好就用镜像
$ composer config -g repo.packagist composer https://packagist.phpcomposer.com
 
# 安装依赖
$ composer install
  
# 复制根目录下的.env.example 为 .env 填写配置, 还有database.php中配置表前缀
$ cp .env.example .env
  
# 加载自定义文件
$ composer dump-autoload  
   
# 生成应用密钥
$ php artisan key:generate
  
# 生成token密钥
$ php artisan jwt:secret
  
# 数据库迁移
$ php artisan migrate
  
# 生成后台框架的表(会报错, 但是是正常的)
$ php artisan admin:install
  
# 填充数据
$ php artisan db:seed
  
# 生成ide对laravel的支持(似乎有部分不成功), 同时在ide中搜索插件Laravel Plugin
$ php artisan ide-helper:generate
  
# 需要权限的目录
$ chmod -R 777 public
$ chmod -R 777 storage

```


## 使用的第三方库

*注意: 没带链接的去 gitHub 直接搜, 部分上不了, 对开发没影响的不做说明*

* [encore/laravel-admin:](http://laravel-admin.org/docs/#/zh/) 用于搭建后台, 进入安装里面的laravel-admin-ext/helpers扩展
* [dingo/api:](https://github.com/liyu001989/dingo-api-wiki-zh) 用于构建api
* [barryvdh/laravel-cors:](https://github.com/barryvdh/laravel-cors/blob/master/readme.md) 用于api跨域请求
* [overtrue/wechat:](https://easywechat.org/zh-cn/docs/index.html)微信封装
* [tymon/jwt-auth:](https://github.com/tymondesigns/jwt-auth/wiki) 用于生成token及验证


## 开发说明

1. 开发后台请先看[laravel-admin](http://laravel-admin.org/docs/#/zh/) 的文档

2. 提醒错误(一般)用异常, 用这两个新增函数
    ```php
     throw_if(true, new Expetion())
     throw_unless(false, new Expetion())
    ```
    
3. 路由用restful风格的get, post, put ,delete

4. 建表直接用后台提供的脚手架, 不管字段长度的影响, 没有值就设为NULL, 
    <br>对表的修改通过迁移文件管理, 看英文就懂意义的字段不要写注释
    ```base
    常用:
    title   => 标题,
    sort    => 排序,
    status  => 状态,
    image   => 图片,
    url     => 链接
      
    只有0和1两个值的字段默认1为true,0为false
    ```
   
## 新增配置文件

* admin.php: 后台系统配置
* api.php: api配置
* jwt.php: jwt token配置
* cors.php: api跨域请求配置

## env配置(必配项和需要说明的项)
* DB_*: 以DB_开头的数据库配置
* APP_URL: 网站域名,本地带端口的也要写上,不然后台图片显示不正确
* CLIENT_URL: 后端做完微信授权后跳转回前端的网址
* USE_HTTPS: 是否使用https, 目前只用于控制后台框架是否开启https, 不对的话资源会加载不正确
   
## 部分功能的设计

1. 对于后台的一些配置项, 通过一下方式存储, 使用时调用get_setting('配置名')获取配置项

    ```bash
    '配置名' => json_encode('配置项数组')
    ```
    
2. 微信处理的入口在App\Http\Controllers\WechatController.php

3. 微信授权: 客户端判断没有token就跳转到服务端
            ->由服务端进行授权处理
            ->获取到用户信息用此信息生成token
            ->通过cookie返回给客户端
            ->把cookie中的token转存到sessionStorage中(关闭网页后删除)
            ->客户端用token调用获取验证用户信息api
            ->客户端获取到用户信息后保存在客户端本地, 视为已登录

## 上线部署

```bash
# 拉取代码
$ git pull
      
# 有新的依赖就安装
$ composer install
    
# 有新的迁移文件就运行
$ php artisan migrate
```  
    
### (不断完善中, 欢迎指正...)