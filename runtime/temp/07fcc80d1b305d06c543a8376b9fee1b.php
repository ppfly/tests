<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"D:\EProject\wwwroot\tests\public\..\application\admin\view\index\info.html";i:1482762954;}*/ ?>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
<link rel="stylesheet" href="__PUBLIC__/css/pintuer.css">
<link rel="stylesheet" href="__PUBLIC__/css/admin.css">
<script src="__PUBLIC__/js/jquery.js"></script>
<script src="__PUBLIC__/js/pintuer.js"></script>
</head>
<body>
<div class="panel admin-panel">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>系统信息</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="">
      <div class="form-group">
        <div class="label">
          <label for="sitename">操作系统版本：</label>
        </div>
        <div class="field">
          <label style="line-height:33px;">
            <?php echo PHP_OS; ?>
          </label>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label for="sitename">运行环境：</label>
        </div>
        <div class="field">
          <label style="line-height:33px;">
            <?php echo $_SERVER['SERVER_SOFTWARE']; ?>
          </label>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label for="sitename">MySQL版本：</label>
        </div>
        <div class="field">
          <label style="line-height:33px;">
            <?php $system_info_mysql = \think\Db::query("select version() as v;"); ?> <?php echo $system_info_mysql['0']['v']; ?>
          </label>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label for="sitename">PHP上传限制：</label>
        </div>
        <div class="field">
          <label style="line-height:33px;">
            <?php echo ini_get('upload_max_filesize'); ?>
          </label>
        </div>
      </div>

    </form>
  </div>
</div>

</body></html>