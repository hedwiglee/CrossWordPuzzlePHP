<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
$URL=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$geturl=str_replace('.html','',$URL);

$queryall=explode('?',$geturl);
$urlquery = explode('&',$queryall[1]); //将问号后面的内容提取出来并用“&”分隔

$qName=substr_replace($urlquery[0],'',0,5);
$qScore=substr_replace($urlquery[1],'',0,6);

$con=mysql_connect("localhost:3306","root","");
if (!$con)
{
	die("Could not connect mysql".mysql_error());
}

mysql_select_db("test1", $con);
mysql_query("SET NAMES UTF8",$con);
$result=mysql_query("SELECT NAME,SCORE FROM SCORE WHERE SCORE>".$qScore,$con);
$jsonwithdot='';
echo "{";
while($row = mysql_fetch_array($result))
{
  $arr=array('NAME'=>$row['NAME'],'SCORE'=>$row['SCORE']);
  $jsonstr=json_encode($arr);
  $jsonwithdot=$jsonwithdot.preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $jsonstr).",";
} 
echo substr($jsonwithdot,0,strlen($jsonwithdot)-1);//去掉最后一个逗号
echo "}";
mysql_close($con);

?>

</body>
</html>