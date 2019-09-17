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
 <h1>毕业管理</h1>  
 <br><br>
<form role="form" action="bygl.php" method="post" target="nm_iframe">
  <div class="form-group">
    <label for="sno">输入毕业学生的学号</label>
    <input type="text" class="form-control" name="sno" placeholder="请输入学号">
  </div>
  
  
  <button type="submit" class="btn btn-default" value="提交" name="submit">提交</button>
</form>
<iframe id="id_iframe" name="nm_iframe" style="display:none;"></iframe>
</body>
</html>
<?php  
if(isset($_POST["submit"]) && $_POST["submit"] == "提交")  
{  
    $sno = $_POST["sno"];  
			
    if($sno == "" )  
    {  
        echo "<script>alert('请输入学号！'); </script>";  
    }  
    else  
    {  $mysqli = new mysqli($server, $db_user, $db_passwd,$db_name);
        $mysqli->set_charset('utf8');
		$sql = "delete from  student_info where sno = ?";
		$sql2= "delete from  grade_info where sno = ?";
		$stmt = $mysqli->stmt_init();  
		
		$stmt ->prepare($sql);
		$stmt->bind_param('i',$sno);
		$stmt->execute();
		
		$stmt ->prepare($sql2);
		$stmt->bind_param('i',$sno);
		$stmt->execute();
		
		$stmt->close();
		$mysqli->close();
		echo "<script>alert('提交成功！'); </script>";  
    }  
}  

?>
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   