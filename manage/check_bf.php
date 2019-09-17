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
			$t1 = $_POST["t1"];  
			$t2 = $_POST["t2"];  
            $t3 = $_POST["t3"]; 
			$t4 = $_POST["t4"]; 
		$fname=$_POST["fname"];
			
			if($t1 == ""&&$t2 == ""&& $t3 == ""&&$t4 == "")  
            {  
                echo "<script>alert('至少选择一个表'); </script>";  
            }  
            else  
            {  
                if($t1 == 1&&$t2 == 1&& $t3 == 1&&$t4 == 1)
				{
					exec("E:\phpstudy\PHPTutorial\MySQL\bin\mysqldump -uroot -proot student_status > data/".$fname.".dump");
					 
				}
				else
				{
					$str=(($t1==1)?"manager ":"").(($t2==1)?"student_info ":"").(($t3==1)?"grade_info ":"").(($t4==1)?"log ":"");
					exec("E:\phpstudy\PHPTutorial\MySQL\bin\mysqldump -uroot -proot student_status ".$str." > data/".$fname.".dump");
				}
				echo "<script>alert('备份成功'); </script>";  
				
            }  
        }  
         
?>
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   