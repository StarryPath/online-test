<?php
session_start();
include("setting.php");
	$sname=$_REQUEST['sname'];
		$sname="%".$sname."%";
		$mysqli = new mysqli($server, $db_user, $db_passwd,$db_name);
		$mysqli->set_charset('utf8');
		$sql = "SELECT  DISTINCT grade_info.sno,sclass,sname,year,term,grade,sage,ssex,saddr from grade_info,student_info where grade_info.sno=student_info.sno and sname like ?";
        
		$stmt = $mysqli->stmt_init();  
		
		$stmt ->prepare($sql);
		$stmt->bind_param('s',$sname);
		$stmt->execute();// 执行SQL语句
		$stmt->store_result();// 取回全部查询结果
		$stmt->bind_result($sno,$sclass,$sname,$year,$term,$grade,$sage,$ssex,$saddr);// 当查询结果绑定到变量中
		$stmt->fetch();
		$array = array("$sno","$sclass","$sname","$year","$term","$grade","$sage","$ssex","$saddr");  
		
		while($stmt->fetch())
		{
		    array_push($array,"$sno","$sclass","$sname","$year","$term","$grade","$sage","$ssex","$saddr");
		}
		echo json_encode($array);
		$stmt->close();
		$mysqli->close();
	


   
?> 
