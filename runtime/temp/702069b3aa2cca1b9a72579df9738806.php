<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"D:\EProject\wwwroot\tests\public\..\application\admin\view\tests\edittest1.html";i:1480948500;}*/ ?>
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
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>修改内容</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" enctype="multipart/form-data" action="<?php echo url('tests/addTest1'); ?>">
      <div class="form-group">
        <div class="label">
          <label>题面：</label>
        </div>
        <div class="field">
          <textarea class="input" name="title" style=" height:90px;"><?php echo $data['title']; ?></textarea>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>图片：</label>
        </div>
        <div class="field">
          <a href="<?php echo $data['pic']; ?>" target="_blank"><img src="<?php echo $data['pic']; ?>" width="100px"/> </a>
          <input type="file" name="pic" class="button bg-blue margin-left" id="image1"   style="float:left;">
          <div class="tipss">图片尺寸：500*500</div>
        </div>
      </div>

      <div class="form-group">
        <div class="label">
          <label>标准答案：</label>
        </div>
        <div class="field" style="padding-top:8px;">
          正确 <input id="r" name="answer"  value="1" type="radio" <?php if($data['answer']==1): ?>checked='checked'<?php endif; ?> />
          错误 <input id="w" name="answer"  value="0" type="radio" <?php if($data['answer']==0): ?>checked='checked'<?php endif; ?> />

        </div>
      </div>
      <input type="hidden" name="type" value="1"/>

      <div class="form-group">
        <div class="label">
          <label></label>
        </div>
        <div class="field">
          <input type="hidden" name="is_update" value="1"/>
          <input type="hidden" name="id" value="<?php echo $data['id']; ?>"/>
          <input type="hidden" name="currentPage" value="<?php echo $currentPage; ?>"/>
          <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
        </div>
      </div>
    </form>
  </div>
</div>

</body></html>