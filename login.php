<?php
//url:login.php?id=XXX&pw=XXX
header("Content-type: text/html; charset=utf-8"); 
$qID=$_GET["id"];
$qPW=$_GET["pw"];

$con=mysql_connect("localhost:3306","root","buptmitc");
if (!$con)
{
	die("Could not connect mysql".mysql_error());
}

mysql_select_db("crosspuzzle", $con);
mysql_query("SET NAMES UTF8",$con);
$result=mysql_query("SELECT UserID,PassWord FROM user WHERE UserID='".$qID."'",$con);
if ($result!="")
{
	if (!mysql_num_rows($result))
	{
		echo "Wrong username!";
	}
	while($row = mysql_fetch_array($result))
	{
	  if ($row['UserID']==$qID&&$row['PassWord']==$qPW)
	  {
		  echo "Success!";
	  }
	  else
	  {
		  echo "Wrong password!";
	  }
	} 
}
else
{
	echo "Error!";
}
mysql_close($con);

?>