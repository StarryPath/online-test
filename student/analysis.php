<?php
	session_start();
	error_reporting(E_ALL || ~E_NOTICE);
	include("setting.php");
	include_once 'global.func.php';
	$kemu=$_SESSION['kemu'];
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
$sum=$dan+$duo+$pan;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>解析页</title>
	<link rel="stylesheet" type="text/css" href="css/analysis.css">
	<script type="text/javascript">
		var initial_fontsize    = 15;

		function setFontsize(type,objname){
		    var oDiv = document.getElementById('wholepage_two');
		    if (oDiv!=null) {
		        if (type==1){
		            if(initial_fontsize<20){
		                oDiv.style.fontSize=(++initial_fontsize)+'px';
		            };
		        }
		        else {
		            if(initial_fontsize>12){
		                oDiv.style.fontSize=(--initial_fontsize)+'px';
		            }
		        }
		    }
		}
		
	</script>
</head>
<body>
	<form method="POST" action="includes/check_shouchang.php">
		<div class="wholepage">
			<div class="logo">
			<div class="font-art">
				<span class="art_two">在线考试系统</span>
			</div>
					<?php
					
					
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
				<div class="head_pic">
					
					<div class="pic_font"><?php echo $html['username']?> </div>
				<?php
					if (isset($_SESSION['username'])) {
						echo "<li class='exit'><a href='startteam.php'>退出&nbsp&nbsp</a></li>";
					} else {
						echo "<li class='exit'>{$_SESSION['username']}</li>";
					}
		
						?>
				</div>
		</div>
			</div>
			<!-- 答题试卷 -->
			<div id="wholepage_two">
				<div class="backg"></div>
				<div class="time">
					<div class="team_name">
						<ul>
							<li style="position: relative;top:20px;"><span><?php echo $kemu;?></span></li>
						</ul>
					</div>
					<div class="submit_one">
						<ul>
							<li  style="position: relative;top:20px;"><span>
								
							</li>
						</ul>
					</div>
					

				</div>
				
				<div class="content">
					<div class="dx_choice">
						<div class="dx_heading"><span style="font-size: 120%;display:block;position: relative;top:15px;left:10px;font-weight: lighter;">单选题（共<?php echo $dan?>题，每题<?php echo $dan_f?>分，共<?php echo $dan*$dan_f?>分）</span></div>

						<div class="dx_problem">
							<?php

								session_start();
								$dxt=$_SESSION['dxt'];
								if (!$dxt) {
									_alert_eo(操作错误);
								}
								unset($_SESSION['dxt']);
								$query100 = mysqli_query($conn,"select * from tom");
								$array100 = mysqli_fetch_array($query100);
								// echo $array100[sz];

								$i=0;
								$x=1;
								while ($x<$dan+1) {
									$query = mysqli_query($conn,"select * from topic where kt_lx='单选题' and id=$dxt[$i]");
									$array = mysqli_fetch_array($query);
							?>
							<div class="problem">
								<span style="margin-left:10px;font-size:17px;position: relative;top:12px">
									<?php echo $x.".".$array["ks_nr"]; ?>
								</span>
								
								<!-- <span class="star" id="star_one"></span> -->
								<div class="checkboxFour">
									<?php
									 echo "<input type=\"checkbox\" value=\"".$dxt[$i]."\"  id=\"checkboxFourInput\"  name=\"".$x."\" class=\"hah\" />";
									 // $ss=array('' => , );
									 
									 ?>
	       							 <label for="checkboxFourInput"></label>
	       							 <!-- <input type="hidden" value="$dxt[$i]" name="$dxt[$i]"> -->
								</div>
								
							</div>
							<?php
								$array1=explode("*",$array["kq_da"]);
								for($a=0;$a<count($array1);$a++){
									if($array1[$a]!=""){
							?>
							<div id="space">
								<input type="radio" name="<?php echo $array[id]; ?>" id="one" value="<?php echo $array1[$a]; ?>"><span><?php echo $array1[$a]; ?></span><br/>
							</div>
							<?php
								}
							}
						
							$query1 = mysqli_query($conn,"select * from transfer where kt_id='$array[id]' and kt_cs=$array100[sz]");

							$array2 = mysqli_fetch_array($query1);
							if($array2[kt_pd]=="yes"){
								$fs=$dan_f;
							}else{
								$fs=0;
							}
							?>
							
							<div class="analysis">
								<span style="font-size:14px;position:relative;top:10px;margin-left:10px">正确答案：</span><span style="font-size:14px;position:relative;top:10px;margin-left:10px"><?php echo $array[zq_da] ?></span><span style="font-size:14px;position:relative;top:10px;margin-left:10px">考生答案：</span><span style="font-size:14px;position:relative;top:10px;margin-left:10px"><?php echo $array2[ks_da]; ?></span><span style="font-size:14px;position:relative;top:10px;margin-left:20px">得分情况：</span><span style="font-size:14px;position:relative;top:10px;margin-left:5px"><?php echo $fs; ?>分</span><br/>
								<span style="font-size:14px;position:relative;top:10px;margin-left:10px">答案解析：</span><br/><span style="font-size:14px;position:relative;top:10px;margin-left:10px"><?php echo $array["kt_jx"] ?></span>
							</div>
							<?php
								
								$i++;
								$x++;
								}
							?>
					<div class="duox_choice">
						
						<div class="duox_heading"><span style="font-size: 120%;display:block;position: relative;top:15px;left:5px;font-weight: lighter;">多选题（共<?php echo $duo?>题，每题<?php echo $duo_f?>分，共<?php echo $duo_f*$duo?>分）</span></div>
						<div class="duox_problem">
							<?php
							$i=$dan;
							$y=$dan+1;
							while ($y<$dan+$duo+1) {
								$query2=mysqli_query($conn,"select * from topic where kt_lx='多选题' and id=$dxt[$i]");
								$array3 = mysqli_fetch_array($query2);
								

						?>
							<div class="problem">
								<span style="margin-left:10px;font-size:17px;position: relative;top:12px"><?php echo $y.".".$array3["ks_nr"]; ?></span>
								<div class="checkboxFour">
									 <?php
									 echo "<input type=\"checkbox\" value=\"".$dxt[$i]."\"  id=\"checkboxFourInput\"  name=\"".$y."\" class=\"hah\" />";
									 // $ss=array('' => , );
									 
									 ?>
	       							 <label for="checkboxFourInput"></label>
	       							 <!-- <input type="hidden" value="$dxt[$i]" name="$dxt[$i]"> -->
								</div>
								
								
							</div>
							<?php
								$array4=explode("*",$array3["kq_da"]);
								for($a=0;$a<count($array4);$a++){
									if($array4[$a]!=""){
							?>
							<div id="space">
								<input type="checkbox" name="<?php echo $array3[id]; ?>" id="one" value="<?php echo $array4[$a]; ?>"><span><?php echo $array4[$a]; ?></span><br/>
							</div>
							<?php
									}
								}
								$query3 = mysqli_query($conn,"select * from transfer where kt_id='$array3[id]' and kt_cs=$array100[sz]");

							$array5 = mysqli_fetch_array($query3);

							if($array5[kt_pd]=="yes"){
								$fs=$duo_f;
							}else{
								$fs=0;
							}
							?>
							<div class="analysis">
								<span style="font-size:14px;position:relative;top:10px;margin-left:10px">正确答案：</span><span style="font-size:14px;position:relative;top:10px;margin-left:10px"><?php echo $array3[zq_da]; ?></span><span style="font-size:14px;position:relative;top:10px;margin-left:10px">考生答案：</span><span style="font-size:14px;position:relative;top:10px;margin-left:10px"><?php echo $array5[ks_da]; ?></span><span style="font-size:14px;position:relative;top:10px;margin-left:20px">得分情况：</span><span style="font-size:14px;position:relative;top:10px;margin-left:5px"><?php echo $fs; ?></span><br/>
								<span style="font-size:14px;position:relative;top:10px;margin-left:10px">答案解析：</span><br/><span style="font-size:14px;position:relative;top:10px;margin-left:10px"><?php echo $array3[kt_jx]; ?></span>
								
							</div>	
							<?php
							   
								$i++;
								$y++;
								}
							?>
							
					<div class="pd_choice">
						<div class="pd_heading"><span style="font-size: 120%;display:block;position: relative;top:15px;left:10px;font-weight: lighter;">判断题（共<?php echo $pan?>题，每题<?php echo $pan_f?>分，共<?php echo $pan*$pan_f?>分）</span></div>
						<div class="pd_problem">
							<?php
							
							$z=$dan+$duo+1;
							$i=$dan+$duo;
							while ($z<$sum+1) {
								$query4=mysqli_query($conn,"select * from topic where kt_lx='判断题' and id=$dxt[$i]");
								$array6 = mysqli_fetch_array($query4)
						?>
							<div class="problem">
								<span style="margin-left:10px;font-size:17px;position: relative;top:12px"><?php echo $z.".".$array6["ks_nr"]; ?></span>
								<div class="checkboxFour">
									 <?php
									 echo "<input type=\"checkbox\" value=\"".$dxt[$i]."\"  id=\"checkboxFourInput\"  name=\"".$z."\" class=\"hah\" />";
									 // $ss=array('' => , );
									 
									 ?>
	       							 <label for="checkboxFourInput"></label>
	       							 <!-- <input type="hidden" value="$dxt[$i]" name="$dxt[$i]"> -->
								</div>
								
								
							</div>
							<?php
								$array7=explode("*",$array6["kq_da"]);
								for($a=0;$a<count($array7);$a++){
									if($array7[$a]!=""){
							?>
							<div id="space">
								<input type="radio" name="<?php echo $array6[id]; ?>" id="one" value="<?php echo $array7[$a]; ?>"><span><?php echo $array7[$a]; ?></span><br/>
							</div>
							<?php
									}
								}
								$query6 = mysqli_query($conn,"select * from transfer where kt_id='$array6[id]' and kt_cs=$array100[sz]");

							$array8 = mysqli_fetch_array($query6);
							if($array8[kt_pd]=="yes"){
								$fs=$pan_f;
							}else{
								$fs=0;
							}
							?>
							<div class="analysis">
								<span style="font-size:14px;position:relative;top:10px;margin-left:10px">正确答案：</span><span style="font-size:14px;position:relative;top:10px;margin-left:10px"><?php echo $array6[zq_da]; ?></span><span style="font-size:14px;position:relative;top:10px;margin-left:10px">考生答案：</span><span style="font-size:14px;position:relative;top:10px;margin-left:10px"><?php echo $array8[ks_da]; ?></span><span style="font-size:14px;position:relative;top:10px;margin-left:20px">得分情况：</span><span style="font-size:14px;position:relative;top:10px;margin-left:5px"><?php echo $fs; ?>分</span><br/>
								<span style="font-size:14px;position:relative;top:10px;margin-left:10px">答案解析：</span><br/><span style="font-size:14px;position:relative;top:10px;margin-left:10px"><?php echo $array6[kt_jx]; ?></span>
							</div>	
							<?php
							   
								$i++;
								$z++;
								}
							?>
					</div>
					
				</div>
			</div>
		</div>
		<script src="js/analysis.js"></script>
		</form>
</body>
</html>