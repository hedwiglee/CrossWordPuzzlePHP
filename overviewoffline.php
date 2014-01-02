<?php
//url:overview.php
header("Content-type: text/html; charset=utf-8"); 

$link = mysql_connect("localhost:3306","root","buptmitc");
if (!$link)
{
	die("Could not connect mysql".mysql_error());
}
mysql_query("set names utf8",$link); 
mysql_select_db("crosspuzzle",$link); 
$sql = "select * from levelnumoffline";
$result= mysql_query($sql,$link);
$json="";
$jsonwithdot="";
echo "[";
while($row = mysql_fetch_array($result))
{
  $arr=array('name'=>$row['VolName'],'open_date'=>$row['OpenDate'],'amount_of_levels'=>(int)$row['LevelNums'],'vol_no'=>(int)$row['VolID']);
  $json=json_encode($arr);
  $jsonwithdot=$jsonwithdot.preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $json).",";
} 
echo substr($jsonwithdot,0,strlen($jsonwithdot)-1);//去掉最后一个逗号
echo "]";

mysql_close($link);

?>
