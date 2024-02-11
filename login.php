<?php
session_start();

// 检查用户是否已经登录，如果已经登录则直接跳转到管理页面
if (isset($_SESSION['user'])) {
    header("Location: admin.php");
    exit;
}

require_once 'config.php'; // 引入数据库配置文件

// 处理用户登录
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 查询数据库中是否存在匹配的用户
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // 用户验证成功，将用户信息存储在 session 中，并跳转到管理页面
        $_SESSION['user'] = $username;
        header("Location: admin.php");
        exit;
    } else {
        $loginError = "用户名或密码错误";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户登录</title>
    <!-- 引入 Bootstrap 样式表 -->
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-5 text-center">用户登录</h1>
        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">用户名</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">密码</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <?php if (isset($loginError)) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $loginError; ?>
                </div>
            <?php } ?>
            <button type="submit" class="btn btn-primary">登录</button>
        </form>
    </div>
</body>
</html>
