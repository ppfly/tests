<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"D:\EProject\wwwroot\tests\public\..\application\admin\view\lib\addlib.html";i:1481123334;}*/ ?>
<!DOCTYPE html>
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
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>增加题库</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="<?php echo url('lib/addLib'); ?>">
      <div class="form-group">
        <div class="label">
          <label>判断题数量：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="" name="test1"/>
          <div class="tips">当前共有<?php echo $test1_num; ?>道习题</div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>单选题数量：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="" name="test2"/>
          <div class="tips">当前共有<?php echo $test2_num; ?>道习题</div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>多选题数据：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="" name="test3"/>
          <div class="tips">当前共有<?php echo $test3_num; ?>道习题</div>
        </div>
      </div>

      <div class="form-group">
        <div class="label">
          <label></label>
        </div>
        <div class="field">
          <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
        </div>
      </div>
    </form>
  </div>
</div>

</body></html>