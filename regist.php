<?php
//regist.php?id=xxx&pw=xxx&name=xxx
header("Content-type: text/html; charset=utf-8"); 
$qID=$_GET["id"];
$qPW=$_GET["pw"];
$qName=$_GET["name"];

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
