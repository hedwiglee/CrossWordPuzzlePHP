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
        <form action="upload.php" method="post" enctype="multipart/form-data">
        游戏名称：<input type="text" name="gamename" /><br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;类型：<input type="text" name="type" /><br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;难度： <input type="text" name="degree" /><br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;作者：<input type="text" name="author" /><br />
        <br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;期号：
        <?php
        $con=mysql_connect("localhost:3306","root","buptmitc");
        mysql_select_db("crosspuzzle",$con);
        mysql_query("SET NAMES UTF8",$con);
        if (!$con)
        {
            die("数据库连接错误！");
        }
        $res = mysql_query("select VolID from vols order by VolID desc",$con);
        $volarray = array();
        $i=1;
        while ($row = mysql_fetch_assoc($res) )
        {
            $volarray[$i] = $row['VolID'];
            $i=$i+1;
        }
        ?>
        <select name="vols" id="vols">
            <option value="<?php echo ($volarray[1]+1); ?>"><?php echo $volarray[1]+1; ?></option>
        <?php foreach ( $volarray as $id=>$vol ) { ?>
            <option value="<?php echo $vol; ?>"><?php echo $vol; }?></option>
        </select><br />
        &nbsp;&nbsp;&nbsp;期名称：<input type="text" name="volname" /><br />
        开播日期：<input type="date" name="opendate" /><br />
        上传文件：<input type="file" name="file" id="file" /><br />
        <input type="submit" id="submit" value="确定" />
        </form>
    </div>
</div>
</body>
</html>