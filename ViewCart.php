<!--这是购物车页面-->
<?php
session_start();//开始
//连接数据库
$db=new MySQLi("localhost","root","root","db_test");
!mysqli_connect_error() or die("连接失败");
$db->query("set names utf8");
$strpice=@$_GET["strpice"];//接收从index.php传过来的商品总价
$ids=@$_GET["ids"];
$dlStr=@$_SESSION["dlStr"];//超全局
//查询数据
$sql="select a.ids,".
    "a.ordercode,".
    "b.name,".
    "b.price,".
    "count(a.count) ".
    "from tb_orderdetails as a ".
    "join tb_fruit as b ".
    "on a.fruitcode=b.ids group by b.name;";
    $res=$db->query($sql);
    $spattr=$res->fetch_all();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>购物车</title>
</head>

<body>
<a href="Login.php">登录</a>
<h1>大苹果购物网</h1><h2>购物车订单</h2>
<div>
    <a href="showList.php">浏览商品</a>&nbsp;&nbsp;
    <a href="ViewAccount.php">查看账户</a>&nbsp;&nbsp;
    <a href="ViewCart.php">查看购物车</a>&nbsp;&nbsp;
</div>

<table width="100%" border="1">
    <tr>
        <th>商品名称</th>
        <th>商品单价</th>
        <th>购买数量</th>
        <th>操作</th>
    </tr>
    <?php foreach($spattr as $v){ ?>
        <tr>
            <td><?php echo $v[2]; ?></td>
            <td><?php echo $v[3]; ?></td>
            <td><?php echo $v[4]; ?></td>
            <td>
            <a href="../gouwuchegai/adf.php?id=<?php echo 1234 ?>"></a>
                <form action="delchuli.php?name=<?php echo $v[2]; ?>" method="post">
                    <input type="hidden" name="orderCode"
                    value="<?php echo $v[1]; ?>">
                    <button>删除</button>
                </form>
            </td>
        </tr>
    <?php }
    ?>
</table>
<a href="dingdanchuli.php?strpice=<?php echo $strpice ?>&ids=<?php echo $ids ?>">提交订单</a>
</body>
</html>