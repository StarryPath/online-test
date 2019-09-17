<?php
session_start();
error_reporting(E_ALL || ~E_NOTICE);
include_once 'global.func.php';
include_once 'setting.php';
$sd=$_SESSION['gesu'];
  
    for ($i=0; $i <$sd ; $i++) { 
		if ($_POST['submit'.$i]) {
		$kemu=$_POST['submit'.$i];
	}
	}
	
	$_SESSION['kemu']=$kemu;	
	if (!$kemu) {
			_alert_eo(操作错误);
		}	
$mysqli = new mysqli($server, $db_user, $db_passwd,$db_name);
$query = "SELECT  * from shijuan where sj_name='$kemu' ";
$stmt = $mysqli->stmt_init();   
$stmt->prepare($query);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($sj_id,$sj_name,$kssj,$dan,$duo,$pan,$nanyi,$dan_f,$duo_f,$pan_f);
$stmt->fetch();
$stmt->close();
$mysqli->close();

$sql = "SELECT * FROM topic  where kt_lx='单选题'and ks_lx='$nanyi'";
$sql_1 ="SELECT * FROM topic  where kt_lx='多选题'and ks_lx='$nanyi'";
$sql_2 ="SELECT * FROM topic  where kt_lx='判断题'and ks_lx='$nanyi'";
$result = mysqli_query($conn,$sql);
$result_1 = mysqli_query($conn,$sql_1);
$result_2 = mysqli_query($conn,$sql_2);
$row = mysqli_fetch_array($result);
$row_1 = mysqli_fetch_array($result_1);
$row_2 = mysqli_fetch_array($result_2);
$temp=array();
do{
  $temp_1[]=$row;
}while($row = mysqli_fetch_array($result));
do{
  $temp_2[]=$row_1;
}while($row_1 = mysqli_fetch_array($result_1));
do{
  $temp_3[]=$row_2;
}while($row_2 = mysqli_fetch_array($result_2));
$temp = array_merge($temp_1,$temp_2,$temp_3);
// var_dump($temp);

$ww=count($temp_1);//返回数组中元素的数目
$sb=range(0,$ww-1); //创建一个包含指定范围的元素的数组
$sj=array_rand($sb,$dan);//返回包含随机键名的数组

$ww_1=count($temp_1)+count($temp_2);
$sb_1=range($ww,$ww_1-1);
$w=array_rand($sb_1,$duo);

$ww_2=count($temp_1)+count($temp_2)+count($temp_3);
$sb_2=range($ww_1,$ww_2-1);
$e=array_rand($sb_2,$pan);


//答案
$hello = array();
for($x=0;$x<$dan;$x++)
{
	$hello[$x]=explode('*',$temp[$sj[$x]]['kq_da']);
}
for($x=0;$x<$duo;$x++)	
{
	$hello[$dan+$x]=explode('*',$temp[$sb_1[$w[$x]]]['kq_da']);
}
for($x=0;$x<$pan;$x++)
{
	$hello[$duo+$dan+$x]=explode('*',$temp[$sb_2[$e[$x]]]['kq_da']);
}

//题号
$sdf = array();
for($x=0;$x<$dan;$x++)
{
	$sdf[$x]=$temp[$sj[$x]]['id'];
}
for($x=0;$x<$duo;$x++)	
{
	$sdf[$dan+$x]=$temp[$sb_1[$w[$x]]]['id'];
}
for($x=0;$x<$pan;$x++)
{
	$sdf[$duo+$dan+$x]=$temp[$sb_2[$e[$x]]]['id'];
}
// var_dump($hello);

 // var_dump( $temp[$sb_3[$r[0]]]['id']);
$_SESSION['dxt']=$sdf;//题号
// echo "<pre>";
 //print_r($hello);
 //print_r($_SESSION['dxt']);
 //echo $kemu;
// echo "</pre>";
// <?php
  
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $kemu;?>考试中</title>
	<link rel="stylesheet" type="text/css" href="css/answer.css">
	<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
      <script src="jquery.js"></script>
      <!-- 包括所有已编译的插件 -->
      <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

</head>
<body>
    <form id ="target"action="check_online.php" method="post">
		<div class="wholepage">
			<div class="logo">
				<div class="font-art">
					<span class="art_two">在线考试系统</span>
				</div>
				<!-- 头像名字 -->
				<?php
					include ('conn.php');
					$username = $_SESSION['username'];
					mysqli_select_db($conn,"topic");
					if(isset($_SESSION['username'])){
					$sql = "SELECT * from student_info where sno = '{$_SESSION['username']}'";

					$result = mysqli_query($conn,$sql) or die('连接失败');
					if($html = mysqli_fetch_array($result)){
				//echo $html['face'];
		}
	}
		else{
			echo "<script>alert('请登录');history.go(-1);</script>";
		}
				?>
				<div class="head_pic ">
					
					
					<div class="pic_font"><?php echo $html['username']?> </div>
				<?php
					if (isset($_SESSION['username'])) {
						echo "<li class='exit'><a id='tuichu' href='startteam.php'>退出&nbsp&nbsp</a></li>";
					} else {
						echo "<li class='exit'>{$_SESSION['username']}</li>";
					}
		
						?>
				</div>

			</div>
			<!-- 答题试卷 -->
			<div id="wholepage_two">
				<div class="backg"></div>
				<div class="time">
					<div class="team_name">
						<ul>
							<li><span><?php echo $kemu;?></span></li>
							<li><div id="tr1"></div></li>
							<div id="timer" style="color:red"></div> 
						</ul>
					</div>
					<div class="submit_one">
						<ul>
							<li>
								
							</li>
							<li><div id="enter"><a href="result.php" style="text-decoration:none;"><input type="submit"  value="提交"></a></div></li>
						</ul>
					</div>
				</div>
				<div class="content">
					<div class="dx_choice">
						<div class="dx_heading"><span style="font-size: 120%;display:block;position: relative;top:15px;left:10px;font-weight: lighter;">
						单选题（共<?php echo $dan?>题，每题<?php echo $dan_f?>分，共<?php echo $dan*$dan_f?>分）</span></div>
			<?php 
			for($x=1;$x<=$dan;$x++)
			{
			echo '<div class="problem"><span style="margin-left:10px;font-size:17px;position: relative;top:12px">'.$x.'.';
			echo $temp[$sj[$x-1]]['ks_nr']."</div>";
			for($i=0;$i<count($hello[$x-1]);$i++){
				echo '<div id="space"><label>  <input  name="dxt'.$x.'" type="radio"id="one" value="'.$hello[$x-1][$i].'"/>'.$hello[$x-1][$i].'</label></div>';
			}
			}
			?>
            
          </div>
					<div class="duox_choice">
						<div class="duox_heading"><span style="font-size: 120%;display:block;position: relative;top:15px;left:5px;font-weight: lighter;">
						多选题（共<?php echo $duo?>题，每题<?php echo $duo_f?>分，共<?php echo $duo_f*$duo?>分）</span></div>
						<div class="duox_problem">
			 <?php
			 for($x=1;$x<=$duo;$x++)
			 {
				 echo '<div class="problem"><span style="margin-left:10px;font-size:17px;position: relative;top:12px">'.($x+$dan).'.';
				 echo $temp[$sb_1[$w[$x-1]]]['ks_nr']."</div>";
				 for($i=0;$i<count($hello[$x+$dan-1]);$i++){
					 echo '<div id="space"><label>  <input  name="dxt'.($x+$dan).'[]" type="checkbox"id="one" value="'.$hello[$x+$dan-1][$i].'"/>'.$hello[$x+$dan-1][$i].'</label></div>';
			 }
			 }
			 ?>
              
						</div>
					</div>
					<div class="pd_choice">
						<div class="pd_heading"><span style="font-size: 120%;display:block;position: relative;top:15px;left:10px;font-weight: lighter;">
						判断题（共<?php echo $pan?>题，每题<?php echo $pan_f?>分，共<?php echo $pan*$pan_f?>分）</span></div>
						<div class="pd_problem">
			<?php
			for($x=1;$x<=$pan;$x++)
			{
				echo '<div class="problem"><span style="margin-left:10px;font-size:17px;position: relative;top:12px">'.($x+$dan+$duo).'.';
				echo $temp[$sb_2[$e[$x-1]]]['ks_nr']."</div>";
				for($i=0;$i<count($hello[$x+$dan+$duo-1]);$i++){
					echo '<div id="space"><label>  <input  name="dxt'.($x+$dan+$duo).'" type="radio"id="one" value="'.$hello[$x+$dan+$duo-1][$i].'"/>'.$hello[$x+$dan+$duo-1][$i].'</label></div>';
			}
			}
			//print_r($temp_3);
			//print_r($e);
			?>
               
						</div>
					</div>
					
				</div>
			</div>
		</div>
			
	<SCRIPT LANGUAGE="JavaScript">

var maxtime;
if(window.name==''){ 
 maxtime = <?php echo $kssj*60?>;
 }else{
 maxtime = window.name;
}
  
function CountDown(){
 if(maxtime>=0){
 minutes = Math.floor(maxtime/60);
 seconds = Math.floor(maxtime%60);
 msg = "距离考试结束还有"+minutes+"分"+seconds+"秒";
// document.all["timer"].innerHTML = msg;
 document.getElementById("timer").innerHTML = msg;
 if(maxtime == 5*60) document.getElementById("tr1").innerHTML="注意，还有不到5分钟!";
 --maxtime;
 window.name = maxtime; 
 }
 else{
 clearInterval(timer);
 alert("考试时间到，结束!");
 document.getElementById("target").submit();
 }
}
timer = setInterval("CountDown()",1000);

</SCRIPT>

	</form>
</body>
</html>
