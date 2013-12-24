<?php
$con=mysql_connect("localhost:3306","root","buptmitc");
mysql_select_db("crosspuzzle",$con);
mysql_query("SET NAMES UTF8",$con);
if (!$con)
{
	die("数据库连接错误！");
}
?>