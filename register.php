<?php
header("Content-Type:text/html;charset=utf-8");

//定义数据库连接功能
function connect_to_database() {
    $link = mysqli_connect('localhost', 'root', '123456', 'hct-ds');
    if (!$link) {
        die('连接失败：' . mysqli_connect_error());
    }
    mysqli_set_charset($link, 'utf8');
    return $link;
}

//检查是否提交了注册表
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if ($password != $confirm_password) {
        $error_message = '确认密码不匹配';
    } else {
        //连接到数据库
        $link = connect_to_database();

        //检查数据库中是否已存在用户名
        $result = mysqli_query($link, "SELECT * FROM users WHERE username='$username'");
        if (!$result) {
            die('查询失败：' . mysqli_error($link));
        }

        if (mysqli_num_rows($result) > 0) {
            $error_message = '用户名已经存在';
        } else {
            //将用户注册详细信息插入数据库
            $insert_result = mysqli_query($link, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
            if (!$insert_result) {
                die('插入数据失败：' . mysqli_error($link));
            }
            $message = '注册成功，快去登录吧！';
            echo "<script>
                if (confirm('$message')) {
                    window.location.href='./login.php'
                } else {
                    window.location.href='#'
                }

            </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>hct-ds 注册界面</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<div class="login-container">
<div class="form-container">
    <h1>注册</h1>
    <form action="" method="post">
        <label for="username"><b>用户名</b></label>
        <input type="text" placeholder="请输入用户名" name="username" required>

        <label for="password"><b>密  码</b></label>
        <input type="password" placeholder="请输入密码" name="password" required>

        <label for="confirm-password"><b>确认密码</b></label>
        <input type="password" placeholder="请再次输入密码" name="confirm-password" required>
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
        <button type="submit" name="register">注册</button>
        <div class="button-container">
            <button type="button" onclick="location.href='./login.php';">返回登录</button>
        </div>
    </form>
</div>
</div>
</body>
</html>
