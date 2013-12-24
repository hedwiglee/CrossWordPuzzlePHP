<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="upload.css" />
<title>填字游戏题目上传管理</title>
</head>
<body>
<div id="outline">
	<div id="title"><h2>填字游戏题目上传管理</h2></div>
    <div id="line"></div>
	<div id="center">

<?php
header("Content-type: text/html; charset=utf-8"); 
$con=mysql_connect("localhost:3306","root","buptmitc");
mysql_select_db("crosspuzzle",$con);
mysql_query("SET NAMES UTF8",$con);
if (!$con)
{
	die("数据库连接错误！");
}

$gamename=$_POST["gamename"];
$type=$_POST["type"];
$degree=$_POST["degree"];
$author=$_POST["author"];
$vol=$_POST["vols"];
$volname=$_POST["volname"];
$date=$_POST["opendate"];
$jsondata=str_replace("\\","/",$_FILES["file"]["tmp_name"]);
echo $gamename." ".$type." ".$degree." ".$author."  ".$vol."    ".$volname."    ".$jsondata."<br />";
$findlevel=mysql_query("SELECT LevelNums FROM levelnum WHERE VolID=".$vol,$con);
global $levels;
$levels=1;
if ($findlevel)
{
	while($row = mysql_fetch_array($findlevel))
	{
	  $levels=$row['LevelNums']+1;
	}
	echo "date".date('Y-m-d',time())."<br />";
	if ($levels==1)
	{
		mysql_query("INSERT INTO vols values (".$vol.",'".$volname."','".$date."')",$con);
	}
	$newpuzzle=mysql_query("INSERT INTO playboard (GameName,Type,Degree,Author,VolID,Level,PlayDate) 
						VALUES ('".$gamename."','".$type."',".$degree.",'".$author."',".$vol.",".
						$levels.",'".$date."')",$con);
						
	mysql_query("UPDATE playboard SET `JsonData` = LOAD_FILE('".$jsondata."') WHERE VolID=".$vol." AND Level=".$levels,$con);
}

if ($newpuzzle)
{
	echo "YOU'VE MADE A NEW PUZZLE!";
}
else 
{
	echo "Error!".mysql_error();
}
?>
    </div>
</div>
</body>
</html>