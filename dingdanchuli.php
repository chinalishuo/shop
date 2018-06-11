<?php
    session_start();
    //连接数据库
    $db=new MySQLi("localhost","root","root","db_test");
    !mysqli_connect_error() or die("连接失败");
    $db->query("set names utf8");
    $uid=$_SESSION["uid"];//获取超全局变量uid
    $strpice=$_GET["strpice"];//这是商品传过来的总价
    $ids=$_GET["ids"];
    $dlStr=$_SESSION["dlStr"];//余额
    /*sql语句查询订单号*/
    $sql="select code from tb_orders where username='$uid'";
    $res=$db->query($sql);
    $codstr=$res->fetch_all();
    $jg="";
    if($dlStr>=$strpice)
    {
        $jg="提交成功";
        foreach($codstr as $v)
        {
            $sql="update tb_login set account = account-$strpice where username ='$uid'";
            $db->query($sql);
            $sql="update tb_fruit set numbers = numbers-1 where ids ='$ids'";
            $db->query($sql);
            //删除orders表中内容
            $sql="delete from tb_orders where code = '$v[0]'";
            $db->query($sql);
            //删除orderdetails表中的内容
            $sql="delete from tb_orderdetails where ordercode = '$v[0]'";
            $db->query($sql);
        }
    }
    else
    {
        $jg="余额不足";
    }
    //跳转页面
    header("location:ViewAccount.php?jg=$jg");
?>