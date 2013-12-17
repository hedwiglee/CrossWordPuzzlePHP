<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
//url:overview.php?user=xxx&vol=xx&lv=xx
$URL=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$geturl=str_replace('.html','',$URL);

$queryall=explode('?',$geturl);
$urlquery = explode('&',$queryall[1]); //将问号后面的内容提取出来并用“&”分隔

$qUser=substr_replace($urlquery[0],'',0,5);
$qVol=substr_replace($urlquery[1],'',0,4);
$qLv=substr_replace($urlquery[2],'',0,3);

$con=mysql_connect("localhost:3306","root","");
if (!$con)
{
	die("Could not connect mysql".mysql_error());
}

mysql_select_db("test1", $con);
mysql_query("SET NAMES UTF8",$con);

//查询前五名
$result=mysql_query("SELECT UserID, Scores
						FROM SCORE
						WHERE CATEGORY =0
						AND VOL =".$qVol."
						AND LEVEL =".$qLv."
						ORDER BY SCORES DESC 
						LIMIT 0 , 5",$con);
$jsonwithdot='';
echo "{top:[";
while($row = mysql_fetch_array($result))
{
  $arr=array('ID'=>$row['UserID'],'SCORE'=>$row['Scores']);
  $jsonstr=json_encode($arr);
  $jsonwithdot=$jsonwithdot.$jsonstr.",";
} 
echo substr($jsonwithdot,0,strlen($jsonwithdot)-1);//去掉最后一个逗号
echo "],";


//查询个人排名
$selfrank=mysql_query("SELECT COUNT( * ) COUNT
						FROM (
						SELECT UserID, Scores
						FROM SCORE
						WHERE category =0
						AND VOL =".$qVol."
						AND LEVEL =".$qLv."
						AND SCORES > ( 
						SELECT SCORES
						FROM SCORE
						WHERE USERID =  '".$qUser."' ) 
						ORDER BY SCORES DESC
						) AS a",$con);
while($rankrow = mysql_fetch_array($selfrank))
{
  echo "rank:".$rankrow['COUNT']."}";
}

mysql_close($con);

?>

</body>
</html>