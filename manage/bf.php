<?php  
session_start();
include("setting.php");
if (isset($_SESSION['username']) && !empty($_SESSION['username']))
{
	header("Content-type: text/html;charset=utf-8");
	error_reporting(E_ALL || ~E_NOTICE);
}
else 
{
	header('Location:login.html');
    exit();
}
?>
<!DOCTYPE html>
<html>
   <head>
      <title>学生学籍管理系统</title>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- 引入 Bootstrap -->
      <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
	 body{padding: 70px} 
</style>
	<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="jquery.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

   </head>
   <body>
 <h1>数据库备份</h1>  
 <br><br>
  <form action="check_bf.php" method="post" target="nm_iframe">
  <label for="name">选择需要备份的表</label>
<div class="checkbox">
<label><input type="checkbox"  name="t1"value="1">管理员信息</label>
</div>
<div class="checkbox">
<label><input type="checkbox" name="t2"value="1">学生档案</label>
</div>
<div class="checkbox">
<label><input type="checkbox" name="t3"value="1">学生成绩</label>
</div>
<div class="checkbox">
<label><input type="checkbox" name="t4"value="1">登录日志</label>
</div>
<div class="form-group">
<label for="name">备份文件名</label>
<input type="text" class="form-control" name="fname" placeholder="请输入文件名">
</div>
<table>
  
</table>
  
  <button type="submit" class="btn btn-default" value="提交" name="submit">提交</button>
</form>
<iframe id="id_iframe" name="nm_iframe" style="display:none;"></iframe>
 </body>
 </html>