<?php
session_start();//开始
//连接数据库
$db = new MySQLi("localhost","root","root","db_test");
!mysqli_connect_error() or die("连接失败");
$db -> query("set names utf8");

//获取传值
$ids = @$_GET["ids"];
$uid = @$_SESSION["uid"];//用户账号
//查询商品表
$sql = "select * from tb_fruit";
$res = $db -> query($sql);
$attr = $res -> fetch_all();
$sql = "select Code from tb_orders where UserName ='$uid'";
$res = $db -> query($sql);
$dhattr=$res -> fetch_all();//单号数组
$dhStr = "";
//数组遍历，转为字符串
foreach($dhattr as $v){
    $dhStr=$dhStr.$v[0]."','";
}
$dhStr=substr($dhStr,0,-3);//截取字符串
$sql="select FruitCode,count(Count) from tb_orderDetails where OrderCode in('$dhStr') group by FruitCode" ;
$res=$db->query($sql);
$spattr=$res->fetch_all();//购物车水果信息数组
$strPice=0;
foreach($attr as $v){
    foreach($spattr as $v1){
        if($v[0]==$v1[0]){
            $strPice=$strPice+$v[2]*$v1[1];
        }
    }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>商品展示</title>
</head>

<body>
<a href="Login.php">登录</a>
<h1>大苹果购物网</h1>
<div>
    <a href="#">浏览商品</a>&nbsp;&nbsp;
    <a href="ViewAccount.php">查看账户</a>&nbsp;&nbsp;
    <!--将商品总价传到购物车页面-->
    <a href="ViewCart.php?strpice=<?php echo $strPice ?>&ids=<?php echo $ids ?>">查看购物车</a>
</div>
<div>
    购物车中有<span id="spnum"><?php echo count($spattr); ?></span>种商品，总价格：<span id="sppice"><?php echo $strPice; ?></span>元。
</div>

<table  width="70%" border="1" >
    <tr>
        <th>代号</th>
        <th>水果名称</th>
        <th>水果价格</th>
        <th>原产地</th>
        <th>货架</th>
        <th>库存量</th>
        <th>操作</th>
    </tr>
    <?php
        foreach($attr as $k=>$v){
    ?>
        <tr>
            <td><?php echo $v[0]; ?></td>
            <td><?php echo $v[1]; ?></td>
            <td><?php echo $v[2]; ?></td>
            <td><?php echo $v[3]; ?></td>
            <td><?php echo $v[4]; ?></td>
            <td><?php echo $v[5]; ?></td>
            <td>
            	<form action="add.php?uid=<?php echo $uid; ?>" method="post">
            	    <input type="hidden" name="ids" value="<?php echo $v[0]; ?>">
            	    <button>购买</button>    
            	</form>
            </td>
        </tr>
    <?php
    	}
    ?>
    <span><?php echo @$_GET["kc"] ?></span>
</table>
</body>
</html>