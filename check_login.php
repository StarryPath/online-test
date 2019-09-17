<?php  
header("Content-type: text/html;charset=utf-8");
error_reporting(E_ALL || ~E_NOTICE);
date_default_timezone_set("Asia/Shanghai");
include("setting.php");
$time=date("Y/m/d h:i:s");
$ip = $_SERVER["REMOTE_ADDR"];

            $user = $_POST["username"];  

			
						
            if($user == "")  
            {  
                echo "<script>alert('请输入学号！'); history.go(-1);</script>";  
            }  
            else  
            {  
                $mysqli = new mysqli($server, $db_user, $db_passwd,$db_name);
                $query = "SELECT sno from student_info where (sno = ?)";
                $stmt = $mysqli->stmt_init();   
				if ($stmt->prepare($query)) 
				{
					$stmt->bind_param("s", $user);
					$stmt->execute();
				}
				
				$stmt->bind_result($uname, $pword);
				$state=1;
                if($stmt->fetch())  
                {  
                    session_start();
					$_SESSION['username']=$user;
					setcookie ( "user_cookie", md5($user) ); 	
					
                }  
                else  
                {  
					$state=0;
                    echo "<script>alert('学号不正确！');history.go(-1);</script>";  
                }
				$info="insert into log(username,logintime,state,ip) values(?,?,?,?)";
				
						
				$stmt ->prepare($info);
				$stmt->bind_param('ssds',$user,$time,$state,$ip);
				$stmt->execute();	
				$stmt->close();
				$mysqli->close();	
					if($state==1)	
						header("Location: student/startteam.php");
            }  
        
      
?>  