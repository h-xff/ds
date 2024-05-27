<?php
session_start();

// 连接数据库
$conn = mysqli_connect('localhost', 'root', '123456', 'hct-ds');
mysqli_set_charset($conn, 'utf8');

// 删除购物车中的商品逻辑
if (isset($_POST['remove_item'])) {
    $product_id = $_POST['id'];
    unset($_SESSION['cart'][$product_id]);
}

// 清空购物车逻辑
if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    $_SESSION['cart'] = array();
}

// 结算逻辑
if (isset($_POST['checkout'])) {
    // 清空购物车并显示成功消息
    unset($_SESSION['cart']);
    $_SESSION['cart'] = array();
    $success_message = "购买成功！";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>hct-ds 购物车</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 引入 Bootstrap 样式 -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">购物网站</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="./index.php">首页</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">购物车</a>
      </li>
      <li class="nav-item">
        <div class="navbar-text mr-2">欢迎用户:<?php echo $_SESSION['username']; ?>！</div>
      </li>
      <li class="nav-item">
        <button class="btn btn-primary" type="button" onclick="location.href='./logout.php';">注销</button>
      </li>
    </ul>
  </div>
</nav>

<div class="container my-4">
<h1>购物车</h1>

<?php if (empty($_SESSION['cart'])): ?>
    <p>您的购物车为空。</p>
<?php else: ?>
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>名称</th>
                <th>价格</th>
                <th>数量</th>
                <th>总价</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $product_id => $quantity): ?>
                <?php
                    // 从数据库中获取产品详情
                    $query = "SELECT id, name, price FROM products WHERE id={$product_id}";
					$result = mysqli_query($conn, $query);
					                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    $total_price = $row['price'] * $quantity;
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo '¥' . number_format($row['price'], 2); ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td><?php echo '¥' . number_format($total_price, 2); ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?php echo $product_id; ?>">
                            <button type="submit" class="btn btn-danger" name="remove_item">删除</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="4" class="text-right">总计：</td>
            <td><?php 
                    // 计算所有产品的总价
                    $total_price = array_sum(array_map(function ($quantity, $product_id) use ($conn) {
                        // 根据产品ID从数据库获取产品价格
                        $query = "SELECT price FROM products WHERE id={$product_id}";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) == 1) {
                            $row = mysqli_fetch_assoc($result);
                            return $row['price'] * $quantity;
                        }
                    }, $_SESSION['cart'], array_keys($_SESSION['cart'])));
                    echo '¥' . number_format($total_price, 2); 
                    ?></td>
                    <td>
                        <form method="post">
                            <button type="submit" class="btn btn-danger" name="clear_cart">清空购物车</button>
                        </form>
                        <form method="post">
                            <button type="submit" class="btn btn-primary mt-2" name="checkout">结算</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php endif; ?>
	</div>
</body>
</html>
<?php
// 关闭数据库连接
mysqli_close($conn);
?>
