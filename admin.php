<?php
session_start();

// 检查用户是否已经登录，如果未登录则跳转到登录页面
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once 'config.php'; // 引入数据库配置文件

// 修改密码
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $newPassword = $_POST['password'];

    // 使用预处理语句来执行 SQL 查询，确保安全
    $stmt = $conn->prepare("UPDATE users SET password=? WHERE username=?");
    $stmt->bind_param("ss", $newPassword, $_SESSION['user']);
    if ($stmt->execute()) {
        // 修改密码后注销当前会话，要求用户重新登录
        session_destroy();
        echo "<script>alert('密码修改成功，请重新登录');</script>";
        echo "<script>window.location.href = 'login.php';</script>";
        exit;
    } else {
        echo "<script>alert('密码修改失败');</script>";
    }
    $stmt->close();
}

// 删除文件
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $fileId = $_GET['delete'];

    // 使用预处理语句来执行 SQL 查询，确保安全
    $stmt = $conn->prepare("DELETE FROM files WHERE id = ?");
    $stmt->bind_param("i", $fileId);
    if ($stmt->execute()) {
        echo "<script>alert('文件删除成功');</script>";
    } else {
        echo "<script>alert('文件删除失败');</script>";
    }
    $stmt->close();
}

// 读取数据库中的文件记录
$sql = "SELECT * FROM files";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台管理页面</title>
    <!-- 引入 Bootstrap 样式表 -->
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* 自定义样式 */
        body {
            background-color: #f8f9fa;
        }

        .container {
            padding-top: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .file-link {
            word-break: break-all;
        }

        /* 弹窗样式 */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-5 text-center">后台管理页面</h1>
        <p class="text-right">
            欢迎您，<?php echo $_SESSION['user']; ?> 
            <button onclick="document.getElementById('myModal').style.display='block'" class="btn btn-primary">修改密码</button>
            <a href="logout.php" class="btn btn-danger">退出登录</a>
        </p>

        <!-- 弹窗内容 -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
                <h2 class="my-4">修改密码</h2>
                <form method="post">
                    <div class="mb-3">
                        <label for="password" class="form-label">新密码</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">保存</button>
                </form>
            </div>
        </div>

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
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['filename']}</td>";
                    echo "<td class='file-link'>{$row['filelink']}</td>";
                    echo "<td><a href='edit.php?id={$row['id']}' class='btn btn-primary'>编辑</a> <a href='?delete={$row['id']}' class='btn btn-danger'>删除</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="add.php" class="btn btn-success">添加文件</a>
    </div>

    <!-- 弹窗脚本 -->
    <script>
        // 获取弹窗
        var modal = document.getElementById('myModal');

        // 当用户点击模态框之外的区域，关闭模态框
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
