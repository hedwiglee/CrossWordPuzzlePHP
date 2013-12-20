<?php
//url:rank.php?user=xxx&vol=xx
header("Content-type: text/html; charset=utf-8"); 
$qUser=$_GET["user"];
$qid=$_GET["vol"];

$con=mysql_connect("localhost:3306","root","buptmitc");
if (!$con)
{
	die("Could not connect mysql".mysql_error());
}

mysql_select_db("crosspuzzle", $con);
mysql_query("SET NAMES UTF8",$con);

//查询前五名
$result=mysql_query("SELECT a.UserID, SUM( a.Scores ) sum
						FROM (
						SELECT s.UserID, s.Scores, p.VolID
						FROM score s, playboard p
						WHERE s.UniqueID = p.UniqueID
						)a
						WHERE a.VolID =".$qid."
						GROUP BY VolID, UserID
						ORDER BY sum DESC 
						LIMIT 0 , 5",$con);
$jsonwithdot='';
echo "[{\"top\":[";
while($row = mysql_fetch_array($result))
{
  $arr=array('ID'=>$row['UserID'],'SCORE'=>(int)$row['sum']);
  $jsonstr=json_encode($arr);
  $jsonwithdot=$jsonwithdot.$jsonstr.",";
} 
echo substr($jsonwithdot,0,strlen($jsonwithdot)-1);//去掉最后一个逗号
echo "],";


//查询个人排名
$selfrank=mysql_query("SELECT COUNT(*) COUNT
						FROM VolScore
						WHERE sum > ( 
							SELECT sum
							FROM VolScore
							WHERE UserID =  '".$qUser."'
							AND VolID =".$qid." ) 
						AND VolID =".$qid,$con);
while($rankrow = mysql_fetch_array($selfrank))
{
  echo "\"rank\":".($rankrow['COUNT']+1)."}]";
}

mysql_close($con);

?>