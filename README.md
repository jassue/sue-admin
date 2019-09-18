SueAdmin
===============

[![Build Status](https://travis-ci.org/top-think/framework.svg?branch=master)](https://travis-ci.org/top-think/framework)
[![License](https://poser.pugx.org/topthink/framework/license)](https://packagist.org/packages/topthink/framework)

SueAdmin是一个整合了RBAC权限管理的基础后台管理系统，前端基于AdminLTE，后端基于ThinkPHP5.1。

<li>PHP >= 7.2</li>
<li>MySql >= 5.7</li>
<li>Redis</li>

## 快速安装

第一步：安装代码
~~~
git clone https://github.com/mattsue/sue-admin.git
composer install
~~~

第二步：配置数据库以及redis
~~~
php think init --db dbtype://username:password@host:port/database#charset --redis password@host:port
例：php think init --db mysql://root:root@127.0.0.1:3306/sue_admin#utf8mb4 --redis @127.0.0.1:6379
~~~

第三步：数据库迁移
~~~
php think migrate:run
php think seed:run
~~~

## 使用docker安装

第一步：安装代码
~~~
git clone https://github.com/mattsue/sue-admin.git
~~~

第二步：创建并启动容器
~~~
docker network create docker_network
docker-compose up -d --build
~~~

第三步：进入容器并执行初始化脚本
~~~
docker exec -it sue-admin bash
sh init.sh
~~~
