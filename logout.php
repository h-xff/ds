<?php
session_start();

//销毁会话并重定向到登录页面
session_destroy();
header('Location: ./login.php');
exit;
?>
