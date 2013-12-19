<?php
//sendscore.php?user=xx&score=xx&id=xx
header("Content-type: text/html; charset=utf-8"); 
$qUser=$_GET["user"];
$qScore=$_GET["score"];
$qid=$_GET["id"];

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