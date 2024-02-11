<?php
session_start();

require_once 'config.php'; // 引入数据库配置文件

// 处理用户提交的登录表单
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取用户输入的用户名和密码
    $username = htmlspecialchars($_POST['username']); // 对用户名进行 XSS 过滤
    $password = htmlspecialchars($_POST['password']); // 对密码进行 XSS 过滤

    // 使用预处理语句执行查询，确保安全
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // 检查查询结果是否有匹配的用户
    if ($result->num_rows == 1) {
        // 用户验证成功，创建用户会话
        $_SESSION['user'] = $username;

        // 生成并设置 CSRF 令牌
        $csrf_token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrf_token;

        // 设置会话 Cookie 属性为 Secure 和 HttpOnly
        session_set_cookie_params([
            'secure' => true,
            'httponly' => true
        ]);

        header("Location: admin.php"); // 登录成功后重定向到后台管理页面
        exit;
    } else {
        // 用户验证失败，显示错误消息
        $error = "用户名或密码错误";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录页面</title>
    <!-- 引入 Bootstrap 样式表 -->
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-5 text-center">登录页面</h1>
        
        <!-- 登录表单 -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">用户名</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">密码</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> <!-- 添加 CSRF 令牌字段 -->
                    <button type="submit" class="btn btn-primary">登录</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
