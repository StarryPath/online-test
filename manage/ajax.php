<?php
include("setting.php");
session_start();
	$sno=$_REQUEST['sno'];
	$mysqli = new mysqli($server, $db_user, $db_passwd,$db_name);
		$mysqli->set_charset('utf8');
		$sql = "select * from  student_info where (sno=?)";
        
		$stmt = $mysqli->stmt_init();  
		
		$stmt ->prepare($sql);
		$stmt->bind_param('i',$sno);
		$stmt->execute();// 执行SQL语句
		$stmt->store_result();// 取回全部查询结果
		$stmt->bind_result($id,$sno2,$sclass,$sname,$sage,$ssex,$saddr);// 当查询结果绑定到变量中
		$stmt->fetch();
		$array = array("$sno2","$sclass","$sname","$sage","$ssex","$saddr");  
		//echo $id,$sno2,$sclass,$sname,$sage,$ssex,$saddr;
		echo json_encode($array);
		$stmt->close();
		$mysqli->close();
	


   
?> 
