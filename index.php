<?php
session_start();

$host = 'localhost';
$user = 'root';
$password = '123456';
$database = 'hct-ds';

// 连接到数据库
$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
  die('无法连接到数据库: ' . mysqli_connect_error());
}

// 如果用户未登录，则重定向到登录页面
if (!isset($_SESSION['username'])) {
  header('Location: ./login.php');
  exit;
}


// 查询所有商品
$sql = "SELECT id, name, description, price, image_path FROM products";
$result = mysqli_query($conn, $sql);
if (!$result) {
  die('查询商品失败: ' . mysqli_error($conn));
}

// 加入购物车逻辑
if (isset($_POST['add_to_cart'])) {
  $product_id = $_POST['id'];

  if (!isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] = 0;
  }

  $_SESSION['cart'][$product_id]++;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>hct-ds 首页</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- 引入 Bootstrap 样式 -->
  <link rel="stylesheet" href="./css/bootstrap.min.css">
   <!--引入 jQuery 和 Bootstrap 核心 JavaScript 文件 -->
  <script src="./js/jquery.min.js"></script>
  <script src="./js/popper.min.js"></script>
  <script src="./js/bootstrap.min.js"></script>
  
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">首页</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav">
      <!-- 购物车按钮 -->
	<li class="nav-item">
		<a class="nav-link" href="./cart.php">购物车 <?php if(isset($_SESSION['cart'])) : ?>
			<span class="badge badge-danger"><?php echo array_sum($_SESSION['cart']); ?></span>
			<?php endif; ?>
		</a>
	</li>

      <li class="nav-item">
        <a class="nav-link" href="./admin.php">管理员</a>
      </li>
      <li class="nav-item">
        <div class="navbar-text mr-2">欢迎用户:<?php echo $_SESSION['username']; ?> </div>
      </li>
      <li class="nav-item">
        <button class="btn btn-primary" type="button" onclick="location.href='./logout.php';">注销</button>
      </li>
    </ul>
  </div>
</nav>

<div class="container my-4">
  <h2>热门商品</h2>
  <div class="row">
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="<?php echo $row['image_path']; ?>" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title"><?php echo $row['name']; ?></h5>
            <p class="card-text"><?php echo $row['description']; ?></p>
            <form method="post">
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
              <button type="submit" class="btn btn-primary" name="add_to_cart"><?php echo '¥' . number_format($row['price'], 2, '.', ','); ?> 添加到购物车</button>
            </form>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
   
  </div>
</div>
<footer class="bg-dark p-4 text-light text-center">
		<div class="container">
			<p class="m-1"><a href="#">企业培训</a> | <a href="#">合作事宜</a> | <a href="#">版权投诉</a></p>
			 <?php echo file_get_contents('./text.txt'); ?>
			<p>京ICP 备12345678. 2023-2030 hct-ds。 Powered by hct.</p>
		</div>
	</footer>


</body>
</html>
<?php
// 关闭数据库连接
mysqli_close($conn);
?>

