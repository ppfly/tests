<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\EProject\wwwroot\tests\public\..\application\admin\view\tests\addtest3.html";i:1481034923;}*/ ?>
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
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>增加多选题</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" enctype="multipart/form-data" action="<?php echo url('tests/addTest3'); ?>">
      <div class="form-group">
        <div class="label">
          <label>题面：</label>
        </div>
        <div class="field">
          <textarea class="input" name="title" style=" height:90px;"></textarea>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>图片：</label>
        </div>
        <div class="field">
          <!--<input type="text" id="pic" name="img" class="input tips" style="width:25%; float:left;"  value=""  data-toggle="hover" data-place="right" data-image="" />-->
          <input type="file" name="pic" class="button bg-blue margin-left" id="image1"   style="float:left;">
          <div class="tipss">图片尺寸：500*500</div>
        </div>
      </div>

      <div class="form-group">
        <div class="label">
          <label>标准答案：</label>
        </div>
        <div class="field" style="padding-top:8px;">
          A <input id="a" name="answer[]"  value="A" type="checkbox" />
          B <input id="b" name="answer[]"  value="B" type="checkbox" />
          C <input id="c" name="answer[]"  value="C" type="checkbox" />
          D <input id="d" name="answer[]"  value="D" type="checkbox" />

        </div>
      </div>
      <input type="hidden" name="type" value="1"/>

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