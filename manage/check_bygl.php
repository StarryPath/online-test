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
            $sno = $_POST["sno"];  
            
			
			
			
						
            if($sno == "" )  
            {  
                echo "<script>alert('请输入学号！'); history.go(-1);</script>";  
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
				echo "<script>alert('提交成功！'); history.go(-1);</script>";  
            }  
        }  
        else  
        {  
            echo "<script>alert('提交未成功！'); history.go(-1);</script>";  
        }  
?>