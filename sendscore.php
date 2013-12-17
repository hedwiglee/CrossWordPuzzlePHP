<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- TemplateBeginEditable name="doctitle" -->
<title>无标题文档</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
</head>

<body>

<?php
//sendscore.php?user=xx&score=xx&vol=xx&lv=xx&type=xx
$URL=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$geturl=str_replace('.html','',$URL);

$queryall=explode('?',$geturl);
$urlquery = explode('&',$queryall[1]); //将问号后面的内容提取出来并用“&”分隔

$qUser=substr_replace($urlquery[0],'',0,5);
$qScore=substr_replace($urlquery[1],'',0,6);
$qVol=substr_replace($urlquery[2],'',0,4);
$qLv=substr_replace($urlquery[3],'',0,3);
$qType=substr_replace($urlquery[4],'',0,5);

$con=mysql_connect("localhost:3306","root","");
if (!$con)
{
	die("Could not connect mysql".mysql_error());
}

mysql_select_db("test1", $con);
mysql_query("SET NAMES UTF8",$con);
$isInsert=mysql_query("INSERT INTO SCORE (USERID,SCORES,VOL,LEVEL,CATEGORY) VALUES ('".$qUser."',".$qScore.",".$qVol.",".$qLv.",".$qType.")",$con);
if ($isInsert)
{
	echo "Successfully insert!";
}
else
{
	echo "Error!";
}

mysql_close($con);

?>

</body>
</html>
