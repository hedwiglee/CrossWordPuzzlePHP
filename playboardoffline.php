<?php
//url:playboardoffline.php
header("Content-type: text/html; charset=utf-8"); 

/*$filename="playboardoffline.txt";
if(!file_exists($filename)){
touch($filename);
}
$fp= fopen($filename,"w") or die("Couldn't open filename");*/
$link = mysql_connect("localhost:3306","root","buptmitc");
//$link = mysql_connect("localhost","root","");
if (!$link)
{
	die("Could not connect mysql".mysql_error());
}
mysql_query("set names utf8",$link); 
mysql_select_db("crosspuzzle",$link); 
$sql="SELECT *FROM playboardoffline";

$result=mysql_query($sql, $link);
$jsonwithdot='';
echo '[';
//fwrite($fp,'[');
while($row = mysql_fetch_array($result))
{
  $arr=array('file'=>$row['FileName'],'uniqueid'=>(int)$row['UniqueID'],'volNumber'=>(int)$row['VolID'],'level'=>(int)$row['Level'],'degree'=>(int)$row['Degree'],
			'category'=>$row['Type'],'islocked'=>(int)$row['Locked'],'star'=>(int)$row['Star'],'words'=>$row['JsonData'],'score'=>(int)$row['Score'],
			'date'=>$row['PlayDate'],'gamename'=>$row['GameName'],'author'=>$row['Author'],'width'=>(int)$row['Width'],'height'=>(int)$row['Height']);
  $jsonstr=json_encode($arr);
  $jsonwithdot=$jsonwithdot.preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $jsonstr).",";
} 
$jsonwith=substr($jsonwithdot,0,strlen($jsonwithdot)-1);//去掉最后一个逗号
echo str_replace(']"',']',str_replace('"[','[',str_replace(' ','',str_replace('\"','"',str_replace('\n','',$jsonwith)))));

echo ']'.'<br />';
//fwrite($fp,str_replace(']"',']',str_replace('"[','[',str_replace(' ','',str_replace('\"','"',str_replace('\n','',$jsonwith))))).']');

mysql_close($link);

?>