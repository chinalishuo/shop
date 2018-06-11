<!--这个页面显示账户余额-->
<?php
    session_start();//开始
    $jg=@$_GET["jg"];//获取从dingdanchuli.php接收的结果值
    $uid=$_SESSION["uid"];//超全局变量uid
    /*连接数据库*/
    $db=new MySQLi("localhost","root","root","db_test");
    !mysqli_connect_error() or die("连接失败");
    $db->query("set names utf8");
    /*sql语句查询余额*/
    $sql="select * from tb_login where username='$uid'";
    $res=$db->query($sql);//执行sql语句
    $dlattr=$res->fetch_row();//获取一维数组结果集
    $_SESSION["dlStr"]=$dlattr[3];//设置全局变量余额dhStr
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>余额</title>
</head>
<body>
<a href="Login.php">登录</a>
<h1>大苹果购物网</h1>
<h2>账户余额：</h2>
<div>
    <a href="showList.php">浏览商品</a>&nbsp;&nbsp;
    <a href="ViewAccount.php">查看账户</a>&nbsp;&nbsp;
    <a href="ViewCart.php">查看购物车</a>&nbsp;&nbsp;
</div>
<span>您的账户中还剩余<?php echo  $dlattr[3]; ?>元。</span><br>
<span style="color:red"><?php echo $jg ?></span>
</body>
</html>