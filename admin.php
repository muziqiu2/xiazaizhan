<?php
session_start();

// 检查用户是否已经登录，如果未登录则跳转到登录页面
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once 'config.php'; // 引入数据库配置文件

// 修改用户名和密码
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password'];

    $sql = "UPDATE users SET username='$newUsername', password='$newPassword'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('用户名和密码修改成功');</script>";
    } else {
        echo "<script>alert('用户名和密码修改失败');</script>";
    }
}

// 删除文件
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $fileId = $_GET['delete'];
    $sql = "DELETE FROM files WHERE id = $fileId";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('文件删除成功');</script>";
    } else {
        echo "<script>alert('文件删除失败');</script>";
    }
}

// 读取数据库中的文件记录
$sql = "SELECT * FROM files";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台管理页面</title>
    <!-- 引入 Bootstrap 样式表 -->
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-5 text-center">后台管理页面</h1>
        <p class="text-right">欢迎您，<?php echo $_SESSION['user']; ?> <a href="logout.php" class="btn btn-danger">退出登录</a></p>
        
        <!-- 修改用户名和密码表单 -->
        <h2 class="my-4">修改用户名和密码</h2>
        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">用户名</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">密码</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">保存</button>
        </form>

        <!-- 文件管理功能代码 -->
        <h2 class="my-4">文件管理</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">文件名</th>
                    <th scope="col">文件链接</th>
                    <th scope="col">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 输出文件记录到表格中
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['filename']}</td>";
                    echo "<td>{$row['filelink']}</td>";
                    echo "<td><a href='edit.php?id={$row['id']}' class='btn btn-primary'>编辑</a> <a href='?delete={$row['id']}' class='btn btn-danger'>删除</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="add.php" class="btn btn-success">添加文件</a>
    </div>
</body>
</html>
