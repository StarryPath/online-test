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
            $year = $_POST["year"]; 
			$term = $_POST["term"]; 
			$grade = $_POST["grade"]; 			
						
            if($sno == "" || $year == ""|| $term == ""|| $grade == "")  
            {  
                echo "<script>alert('请输入全部信息！'); </script>";  
            }  
            else  
            {  $mysqli = new mysqli($server, $db_user, $db_passwd,$db_name);
                $mysqli->set_charset('utf8');
				$sql = "insert into grade_info(sno,year,term,grade) values(?,?,?,?)";
				
				$stmt = $mysqli->stmt_init();  
				
				$stmt ->prepare($sql);
				$stmt->bind_param('iiii',$sno,$year,$term,$grade);
				
				$stmt->execute();
				if($stmt->errno==1452)
					echo "<script>alert('违反外键约束！无此学生学籍');</script>";
				else
					echo "<script>alert('提交成功！');</script>";
				$stmt->close();
				$mysqli->close();
            }  
        }  
        else  
        {  
            echo "<script>alert('提交未成功！'); </script>";  
        }  
?>