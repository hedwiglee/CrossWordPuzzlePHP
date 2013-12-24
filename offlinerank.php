<?php
//url:offlinerank.php?user=xxx
header("Content-type: text/html; charset=utf-8"); 
$qUser=$_GET["user"];

$con=mysql_connect("localhost:3306","root","buptmitc");
if (!$con)
{
	die("Could not connect mysql".mysql_error());
}

mysql_select_db("crosspuzzle", $con);
mysql_query("SET NAMES UTF8",$con);

//查询前五名
$result=mysql_query("SELECT * 
						FROM  `scoreoffline` 
						ORDER BY Scores DESC 
						LIMIT 0 , 5",$con);
$jsonwithdot='';
echo "{\"top\":[";
while($row = mysql_fetch_array($result))
{
  $arr=array('ID'=>$row['UserID'],'SCORE'=>(int)$row['Scores']);
  $jsonstr=json_encode($arr);
  $jsonwithdot=$jsonwithdot.$jsonstr.",";
} 
echo substr($jsonwithdot,0,strlen($jsonwithdot)-1);//去掉最后一个逗号
echo "],";


//查询个人排名
$selfrank=mysql_query("SELECT COUNT( * ) COUNT
						FROM  `scoreoffline` 
						WHERE Scores > ( 
						SELECT Scores
						FROM scoreoffline
						WHERE UserID =  '".$qUser."')",$con);
while($rankrow = mysql_fetch_array($selfrank))
{
  echo "\"rank\":".($rankrow['COUNT']+1)."}";
}

mysql_close($con);

?>