<?php
//url:login.php?id=XXX&pw=XXX
header("Content-type: text/html; charset=utf-8"); 
$URL=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$geturl=str_replace('.html','',$URL);

$queryall=explode('?',$geturl);
$urlquery = explode('&',$queryall[1]); //将问号后面的内容提取出来并用“&”分隔

$qID=substr_replace($urlquery[0],'',0,3);
$qPW=substr_replace($urlquery[1],'',0,3);

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