<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
//url:getlevels.php?id=xxx
$URL=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$geturl=str_replace('.html','',$URL);

$queryall=explode('?',$geturl);
$urlquery = explode('&',$queryall[1]); //将问号后面的内容提取出来并用“&”分隔

$qVol=substr_replace($urlquery[0],'',0,4);

$con=mysql_connect("localhost:3306","root","");
if (!$con)
{
	die("Could not connect mysql".mysql_error());
}

mysql_select_db("test1", $con);
mysql_query("SET NAMES UTF8",$con);
$result=mysql_query("SELECT UniqueID
						FROM playboard
						WHERE VOL =".$qVol."
						AND TYPE =0",$con);
$jsonwithdot='';
echo "{";
while($row = mysql_fetch_array($result))
{
  $arr=array('id'=>$row['UniqueID']);
  $jsonstr=json_encode($arr);
  $jsonwithdot=$jsonwithdot.$jsonstr.",";
} 
echo substr($jsonwithdot,0,strlen($jsonwithdot)-1);//去掉最后一个逗号
echo "}";
mysql_close($con);

?>

</body>
</html>