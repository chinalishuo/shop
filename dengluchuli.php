<?php
session_start();//开启session 必须要写到第一行
//从登录页面获取到用户名和密码
$uid=$_POST["uid"];
$pwd=$_POST["pwd"];
//连接数据库
$db=new MySQLi("localhost","root","root","db_test");
!mysqli_connect_error() or die("连接错误");
$db->query("set names utf8");

//查询密码
$sql="select password from tb_login where username='{$uid}'";
$result=$db->Query($sql);
$arr=$result->fetch_all();
//判断所填写的密码和取到的密码是一样的，而且密码不能为空
if($arr[0][0]==$pwd && !empty($pwd))
  {
     //定义用户uid为超全局变量
     $_SESSION["uid"]=$uid;
     //跳转页面
     header("location:showList.php");
 }
 else
 {
     echo"登录失败";
 }