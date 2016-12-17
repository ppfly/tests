<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR);

define('BASE_PATH', substr($_SERVER['SCRIPT_NAME'], 0, -10));
define('ROOT_PATH', dirname(APP_PATH) . DIRECTORY_SEPARATOR);
define('EXTEND_PATH', ROOT_PATH .  'extend' . DIRECTORY_SEPARATOR);
define('UPLOADS',ROOT_PATH.'public');

// 加载框架引导文件
require __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'thinkphp'.DIRECTORY_SEPARATOR.'start.php';