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

if(isset($_POST["submit"]) && $_POST["submit"] == "提交")  
{  
			$dbname = $_POST["db_name"];  
			
		$path=$_POST["path"];
			
			if($dbname == ""&&$path == "")  
            {  
                echo "<script>alert('请输入完整信息'); </script>";  
            }  
            else  
            {  
                
					exec("E:\phpstudy\PHPTutorial\MySQL\bin\mysql -uroot -proot ".$dbname." < data/".$path);
					 
				
				echo "<script>alert('恢复成功'); </script>";  
				
            }  
        }  
         
?>
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   