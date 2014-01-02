<?php
//sendscore.php?user=xx&score=xx
header("Content-type: text/html; charset=utf-8"); 
$qUser=$_GET["user"];
$qScore=$_GET["score"];

$con=mysql_connect("localhost:3306","root","buptmitc");
if (!$con)
{
	die("Could not connect mysql".mysql_error());
}
mysql_select_db("crosspuzzle", $con);
mysql_query("SET NAMES UTF8",$con);
$haveone=mysql_query("SELECT UserID FROM scoreoffline WHERE UserID='".$qUser."'",$con);
if (mysql_num_rows($haveone))
{
	$isupdate=mysql_query("UPDATE scoreoffline SET Scores=".$qScore." WHERE UserID='".$qUser."'",$con);
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
	$isInsert=mysql_query("INSERT INTO scoreoffline (UserID,Scores) VALUES ('".$qUser."',".$qScore.")",$con);
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