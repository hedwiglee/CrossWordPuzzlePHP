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
$result=mysql_query("SELECT A.Vol, A.Level, A.StartTime
						FROM playboard A, (
						SELECT Vol, MAX( Level ) max_level
						FROM playboard
						GROUP BY Vol
						)B
						WHERE A.Vol = B.Vol
						AND A.Level = B.max_level",$con);
$jsonwithdot='';
echo "{";
while($row = mysql_fetch_array($result))
{
  $arr=array('Vol'=>$row['Vol'],'LvNum'=>$row['Level'],'STime'=>$row['StartTime']);
  $jsonstr=json_encode($arr);
  $jsonwithdot=$jsonwithdot.$jsonstr.",";
} 
echo substr($jsonwithdot,0,strlen($jsonwithdot)-1);//去掉最后一个逗号
echo "}";
mysql_close($con);

?>

</body>
</html>