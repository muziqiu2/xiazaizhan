<?php
session_start();

// 检查用户是否已经登录，如果未登录则跳转到登录页面
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once 'config.php'; // 引入数据库配置文件

// 验证用户权限
if ($_SESSION['user'] !== 'admin') {
    echo "<script>alert('您没有足够的权限执行此操作');</script>";
    exit;
}

// 处理添加文件请求
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $filename = $_POST['filename'];
    $filelink = $_POST['filelink'];

    // 使用预处理语句来执行 SQL 查询，确保安全
    $stmt = $conn->prepare("INSERT INTO files (filename, filelink) VALUES (?, ?)");
    $stmt->bind_param("ss", $filename, $filelink);
    if ($stmt->execute()) {
        echo "<script>alert('文件添加成功');</script>";
    } else {
        echo "<script>alert('文件添加失败');</script>";
    }
    $stmt->close();
}
?>
