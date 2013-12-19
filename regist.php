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
//regist.php?id=xxx&pw=xxx&name=xxx
$URL=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$geturl=str_replace('.html','',$URL);

$queryall=explode('?',$geturl);
$urlquery = explode('&',$queryall[1]); 

$qID=substr_replace($urlquery[0],'',0,3);
$qPW=substr_replace($urlquery[1],'',0,3);
$qName=substr_replace($urlquery[2],'',0,5);

$con=mysql_connect("localhost:3306","root","buptmitc");
if (!$con)
{
	die("Could not connect mysql".mysql_error());
}

mysql_select_db("crosspuzzle", $con);
mysql_query("SET NAMES UTF8",$con);
$haveuserid=mysql_query("SELECT UserID FROM user WHERE UserID='".$qID."'",$con);
if (mysql_num_rows($haveuserid))
{
	echo "Username exists!";
}
else
{
	$insert=mysql_query("INSERT INTO user (UserID,PassWord,UserName) VALUES ('".$qID."','".$qPW."','".$qName."')",$con);
	if ($insert)
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
