<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$user = 'root';
$password = '123456';
$database = 'hct-ds';

// 连接到数据库
$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
  die('连接到数据库失败：' . mysqli_connect_error());
}

// 添加商品逻辑
if (isset($_POST['add'])) {
  $product_name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];

  // 处理图片上传
  $image_path = '';
  if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['image']['tmp_name'];
    $image_name = basename($_FILES['image']['name']);
    $path = "image/$image_name";
    if (move_uploaded_file($tmp_name, $path)) {
      $image_path = $path;
    }
  }

  // 将商品插入数据库
  $sql = "INSERT INTO products (name, description, price, image_path) VALUES (?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, 'ssds', $product_name, $description, $price, $image_path);
  $result = mysqli_stmt_execute($stmt);
  if ($result) {
    echo '<div class="alert alert-success" role="alert">商品已添加。</div>';
  } else {
    echo '<div class="alert alert-danger" role="alert">添加商品时出错：' . mysqli_error($conn) . '</div>';
  }
}

// 删除商品逻辑
if (isset($_POST['delete'])) {
  $product_id = $_POST['id'];

  // 从数据库中删除商品
  $sql = "DELETE FROM products WHERE id=?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, 'i', $product_id);
  $result = mysqli_stmt_execute($stmt);
  if ($result) {
    echo '<div class="alert alert-success" role="alert">商品已删除。</div>';
  } else {
    echo '<div class="alert alert-danger" role="alert">删除商品时出错：' . mysqli_error($conn) . '</div>';
  }
}

// 查询所有商品
$sql = "SELECT id, name, description, price, image_path FROM products";
$result = mysqli_query($conn, $sql);
if (!$result) {
  die('查询商品失败：' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>hct-ds 管理员</title>
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
  <a class="navbar-brand" href="#">管理员</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav">
      <!-- 首页按钮 -->
	<li class="nav-item">
		<a class="nav-link" href="./index.php">首页</a>
	</li>

      <li class="nav-item">
        <div class="navbar-text mr-2">欢迎来到管理员界面，<?php echo $_SESSION['username']; ?>！</div>
      </li>
      <li class="nav-item">
        <button class="btn btn-primary" type="button" onclick="location.href='./logout.php';">注销</button>
      </li>
    </ul>
  </div>
</nav>

<div class="container my-4">
  <h2>添加商品</h2>
  <form method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="name">名称：</label>
      <input type="text" class="form-control" id="name" name="name">
    </div>
    <div class="form-group">
      <label for="description">描述：</label>
      <textarea class="form-control" id="description" name="description"></textarea>
    </div>
    <div class="form-group">
      <label for="price">价格：</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">¥</span>
        </div>
        <input type="number" class="form-control" id="price" name="price" step="0.01">
      </div>
    </div>
    <div class="form-group">
      <label for="image">图片：</label>
      <input type="file" class="form-control-file" id="image" name="image">
    </div>
    <button type="submit" class="btn btn-primary" name="add">添加商品</button>
  </form>

  <hr>

  <h2>所有商品</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>名称</th>
        <th>描述</th>
        <th>价格</th>
        <th>图片</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['description']; ?></td>
          <td><?php echo $row['price']; ?></td>
          <td><img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['name']; ?>" height="50"></td>
          <td>
            <form method="post">
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
              <button type="submit" class="btn btn-danger" name="delete">删除</button>
            </form>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
