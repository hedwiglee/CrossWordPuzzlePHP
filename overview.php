<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
//url:overview.php
$con=mysql_connect("localhost:3306","root","buptmitc");
if (!$con)
{
	die("Could not connect mysql".mysql_error());
}

mysql_select_db("crosspuzzle", $con);
mysql_query("SET NAMES UTF8",$con);
$result=mysql_query("SELECT VolName,OpenDate,LevelNums,VolID 
					FROM vols ",$con);
$jsonwithdot='';
echo "[";
while($row = mysql_fetch_array($result))
{
  $arr=array('name'=>$row['VolName'],'open_date'=>$row['OpenDate'],'amount_of_levels'=>$row['LevelNums'],'vol_no'=>$row['VolID']);
  $jsonstr=json_encode($arr);
  $jsonwithdot=$jsonwithdot.preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $jsonstr).",";
} 
echo substr($jsonwithdot,0,strlen($jsonwithdot)-1);//去掉最后一个逗号
echo "]";
mysql_close($con);

?>

</body>
</html>