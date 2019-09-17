<?php
include_once 'global.func.php';
include_once 'setting.php';
session_start();
error_reporting(E_ALL || ~E_NOTICE);
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

for($x=$dan+1;$x<=$dan+$duo;$x++)//多选题
{
	
	$_POST['dxt'.$x]=implode("",$_POST['dxt'.$x] );//implode() 函数返回由数组元素组合成的字符串
	
}
$dxtdaan = array();
for($x=1;$x<=$sum;$x++)
{
	$dxtdaan[$x-1]=$_POST['dxt'.$x];
}


$dxt=$_SESSION['dxt'];//题号
//var_dump($_SESSION['dxt']);



  $yii="SELECT * FROM tom info where id='1'";
  $result100 = mysqli_query($conn,$yii);
  $row100 = mysqli_fetch_array($result100);
  //print_r($row100);
  // var_dump($row100[1]);
  $wc=$row100[1]+1;
  // var_dump($wc);
   $yii2= "UPDATE `tom` SET sz='{$wc}'WHERE id = '1'";
    mysqli_query($conn,$yii2);


$name=$_SESSION['username'];
  //unset($_SESSION['dxt']);
for ($i=0; $i <$sum; $i++) {
  $sql = "SELECT * FROM topic info where id='$dxt[$i]'";
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_array($result);
  // var_dump($dxt[$i]);
  // var_dump($row['zq_da']);
  // var_dump($dxtdaan[$i]);
  //$str= mb_ereg_replace('^(　| )+', '', "a 2  222 wqebibbcniuef3u3  iunn ");
  //$str = mb_ereg_replace('(　| )+$', '', $str);
  //echo $str;
$str= mb_ereg_replace('^(　| )+', '', $row['zq_da']);
$str = mb_ereg_replace('(　| )+$', '', $str);
$arr= mb_ereg_replace('^(　| )+', '', $dxtdaan[$i]);
$dxtdaan[$i] = mb_ereg_replace('(　| )+$', '', $arr);
  if($str == $dxtdaan[$i]){
   $sql="insert into transfer (kt_user,kt_id,kt_pd,ks_da,kt_cs)values('{$name}','$dxt[$i]','yes','$dxtdaan[$i]',$wc)";
   if (!mysqli_query($conn,$sql)) {
      die ('Error: ' .mysqli_error());
    }

  }else {
    $sql="insert into transfer (kt_user,kt_id,kt_pd,ks_da,kt_cs)values('{$name}','$dxt[$i]','no','$dxtdaan[$i]',$wc)";
   if (!mysqli_query($conn,$sql)) {
      die ('Error: ' .mysqli_error());
    }
}
}

_alert_go("提交成功");

 ?>
