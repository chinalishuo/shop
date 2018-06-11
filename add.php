<?php
session_start();//开始
//连接数据库
$db=new MySQLi("localhost","root","root","db_test");
!mysqli_connect_error() or die("连接失败");
$db->query("set names utf8");

//获取传值
$ids=@$_POST["ids"];
$uid=$_SESSION["uid"];
$date=@date("Y-m-d h:i:s");//获取时间

$sql="select numbers from tb_fruit where ids='$ids'";
$res=$db->query($sql);
$att=$res->fetch_row();
foreach($att as $v)
{
    if($v>0){  //条件判断
        $sql="insert into tb_orders values('$uid"."$date','$uid','$date')";
        $db->query($sql);
        $sql="insert into tb_orderdetails values('','$uid"."$date','$ids',1)";
        $db->query($sql);
        header("location:showList.php?ids=$ids");
    }else{
        header("location:showList.php?kc=库存不足");
    }
}    
?>