<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
//url:playboard.php?id=xx
$URL=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$geturl=str_replace('.html','',$URL);

$queryall=explode('?',$geturl);
$urlquery = explode('&',$queryall[1]); //将问号后面的内容提取出来并用“&”分隔

$qID=substr_replace($urlquery[0],'',0,3);

$con=mysql_connect("localhost:3306","root","buptmitc");
if (!$con)
{
	die("Could not connect mysql".mysql_error());
}

mysql_select_db("crosspuzzle", $con);
mysql_query("SET NAMES UTF8",$con);

$result=mysql_query("SELECT JSONDATA
						FROM PLAYBOARD
						WHERE UNIQUEID=".$qID , $con);
$jsonwithdot='';
while($row = mysql_fetch_array($result))
{
  $arr=array('JSONDATA'=>$row['JSONDATA']);
  $jsonstr=json_encode($arr);
  $jsonwithdot=$jsonwithdot.preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $jsonstr).",";
} 
$jsonwith=substr($jsonwithdot,0,strlen($jsonwithdot)-1);//去掉最后一个逗号
echo str_replace(' ','',str_replace('\"','"',str_replace('\n','',$jsonwith)));
mysql_close($con);

?>

</body>
</html>