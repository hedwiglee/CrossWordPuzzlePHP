<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- TemplateBeginEditable name="doctitle" -->
<title></title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
</head>

<body>

<?php
//sendscore.php?user=xx&score=xx&id=xx
$URL=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$geturl=str_replace('.html','',$URL);

$queryall=explode('?',$geturl);
$urlquery = explode('&',$queryall[1]); //将问号后面的内容提取出来并用“&”分隔

$qUser=substr_replace($urlquery[0],'',0,5);
$qScore=substr_replace($urlquery[1],'',0,6);
$qid=substr_replace($urlquery[2],'',0,3);

$con=mysql_connect("localhost:3306","root","buptmitc");
if (!$con)
{
	die("Could not connect mysql".mysql_error());
}
mysql_select_db("crosspuzzle", $con);
mysql_query("SET NAMES UTF8",$con);
$haveone=mysql_query("SELECT UserID,UniqueID FROM score WHERE UserID='".$qUser."' AND UniqueID=".$qid."",$con);
if (mysql_num_rows($haveone))
{
	$isupdate=mysql_query("UPDATE score SET Scores=".$qScore." WHERE UserID='".$qUser."' AND UniqueID=".$qid."",$con);
	if ($isupdate)
	{
		echo "Successfully insert!";
	}
	else
	{
		echo "Error!";
	}
}
else
{
	$isInsert=mysql_query("INSERT INTO score (UserID,Scores,UniqueID) VALUES ('".$qUser."',".$qScore.",".$qid.")",$con);
	if ($isInsert)
	{
		echo "Successfully insert!";
	}
	else
	{
		echo "Error!";
	}
}
mysql_close($con);

?>

</body>
</html>
