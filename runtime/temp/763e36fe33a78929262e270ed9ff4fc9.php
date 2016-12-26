<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"D:\EProject\wwwroot\tests\public\..\application\admin\view\tests\edittest3.html";i:1482768098;}*/ ?>
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
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>修改多选题</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" enctype="multipart/form-data" action="<?php echo url('tests/addTest3'); ?>">
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
          <ul class="ul_radio">
            <?php $ascii_n=64; if(is_array($option) || $option instanceof \think\Collection): $i = 0; $__LIST__ = $option;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;$ascii_n=$ascii_n+1; ?>
            <li><span><?php echo $key; ?>.</span><input style="width:500px;" type="text" name="option[]" value="<?php echo $item; ?>"/> <input type="checkbox" name="answer[]" value="<?php echo $key; ?>" <?php if (strstr($data['answer'],$key)) echo "checked='checked'" ?>/> </li>
            <?php endforeach; endif; else: echo "" ;endif;  $ascii_n=$ascii_n+1;for($i=$ascii_n;$i<73;$i++){ ?>
            <li><span><?php echo chr($i);; ?>.</span><input style="width:500px;" type="text" name="option[]" value=""/> <input type="checkbox" name="answer[]" value="<?php echo chr($i);; ?>"/></li>
            <?php  }  ?>
          </ul>

        </div>
      </div>
      <input type="hidden" name="type" value="3"/>

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