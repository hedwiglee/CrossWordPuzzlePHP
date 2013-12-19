<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
//url:playboard.php?vol=xx&lv=xx
$URL=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$geturl=str_replace('.html','',$URL);

$queryall=explode('?',$geturl);
$urlquery = explode('&',$queryall[1]); //将问号后面的内容提取出来并用“&”分隔

$qVol=substr_replace($urlquery[0],'',0,4);
$qLv=substr_replace($urlquery[1],'',0,3);

$con=mysql_connect("localhost:3306","root","buptmitc");
if (!$con)
{
	die("Could not connect mysql".mysql_error());
}

mysql_select_db("crosspuzzle", $con);
mysql_query("SET NAMES UTF8",$con);

$result=mysql_query("SELECT UniqueID, Locked, Star, JsonData
						FROM playboard
						WHERE VolID =".$qVol."
						AND Level =".$qLv , $con);
$jsonwithdot='';
echo "[";
while($row = mysql_fetch_array($result))
{
  $arr=array('id'=>$row['UniqueID'],'lock'=>$row['Locked'],'star'=>$row['Star'],'jsondata'=>$row['JsonData']);
  $jsonstr=json_encode($arr);
  $jsonwithdot=$jsonwithdot.preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $jsonstr).",";
} 
$jsonwith=substr($jsonwithdot,0,strlen($jsonwithdot)-1);//去掉最后一个逗号
echo str_replace(' ','',str_replace('\"','"',str_replace('\n','',$jsonwith)));

echo "]";
mysql_close($con);

?>

</body>
</html>