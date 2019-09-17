<?php
include("setting.php");
session_start();
	$tihao=$_REQUEST['tihao'];
	$mysqli = new mysqli($server, $db_user, $db_passwd,$db_name);
		$mysqli->set_charset('utf8');
		$sql = "select * from  topic where (id=?)";
        
		$stmt = $mysqli->stmt_init();  
		
		$stmt ->prepare($sql);
		$stmt->bind_param('i',$tihao);
		$stmt->execute();// 执行SQL语句
		$stmt->store_result();// 取回全部查询结果
		$stmt->bind_result($id,$ks_lx,$kt_lx,$fs,$ks_nr,$kq_da,$zq_da,$kt_jx);// 当查询结果绑定到变量中
		$stmt->fetch();
		$array = array($id,$ks_lx,$kt_lx,$fs,$ks_nr,$kq_da,$zq_da,$kt_jx);  
		//echo $id,$sno2,$sclass,$sname,$sage,$ssex,$saddr;
		echo json_encode($array);
		$stmt->close();
		$mysqli->close();
	


   
?> 
