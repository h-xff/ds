<?php
session_start();


// 检查用户是否已登录，如果已登录，则重定向到首页
if (isset($_SESSION['username'])) {
    header('Location: ./index.php');
    exit;
}

// 处理表单提交
$error_message = '';
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 连接数据库
    $link = mysqli_connect('localhost', 'root', '123456', 'hct-ds');
    if (!$link) {
        die('连接失败：' . mysqli_connect_error());
    }

    mysqli_set_charset($link, 'utf8');

    // 执行 SQL 查询以检查用户名/密码是否匹配
    $result = mysqli_query($link, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    if (!$result) {
        die('查询失败：' . mysqli_error($link));
    }

    // 如果用户名/密码匹配，则启动新会话并重定向到首页
    if (mysqli_num_rows($result) > 0) {
        session_start();
        $_SESSION['username'] = $username;
        header('Location: /index.php');
        exit;
    } else {
        $error_message = '用户名或密码不正确';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>hct-ds 登录界面</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

<div class="login-container">
    <div class="form-container">
        <h1>欢迎回来！</h1>
        <form action="login.php" method="post">
            <div class="input-group">
                <label for="username">用户名</label>
                <input type="text" name="username" placeholder="请输入用户名" required>
            </div>

            <div class="input-group">
                <label for="password">密码</label>
                <input type="password" name="password" placeholder="请输入密码" required>
            </div>

            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <button type="submit" name="login">登录</button>
            <div class="button-container">
                <button type="button" onclick="location.href='./register.php';">注册</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
