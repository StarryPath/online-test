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
            $sclass = $_POST["sclass"]; 
			$sname = $_POST["sname"]; 
			$sage = $_POST["sage"]; 
			$ssex = $_POST["ssex"]; 
			$saddr = $_POST["saddr"];
			
			
			
						
            if($sno == "" || $sclass == ""|| $sname == ""|| $sage == ""|| $ssex == ""|| $saddr == "")  
            {  
                echo "<script>alert('请输入全部信息！'); history.go(-1);</script>";  
            }  
            else  
            {  $mysqli = new mysqli($server, $db_user, $db_passwd,$db_name);
                $mysqli->set_charset('utf8');
				$sql = "insert into student_info(sno,sclass,sname,sage,ssex,saddr) values(?,?,?,?,?,?)";
				
				$stmt = $mysqli->stmt_init();  
				
				$stmt ->prepare($sql);
				$stmt->bind_param('iisiss',$sno,$sclass,$sname,$sage,$ssex,$saddr);
				$stmt->execute();
				if($stmt->errno===1062)
				{
					echo "<script>alert('学号重复！'); history.go(-1);</script>"; 
				}
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