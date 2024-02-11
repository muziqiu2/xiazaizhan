<?php
session_start();

// 检查用户是否已经登录，如果未登录则跳转到登录页面
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
require_once 'config.php'; // 引入数据库配置文件

// 添加文件
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filename = $_POST['filename'];
    $filelink = $_POST['filelink'];

    $sql = "INSERT INTO files (filename, filelink) VALUES ('$filename', '$filelink')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('文件添加成功');window.location='admin.php';</script>";
        exit;
    } else {
        echo "<script>alert('文件添加失败');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>添加文件</title>
    <!-- 引入 Bootstrap 样式表 -->
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-5 text-center">添加文件</h1>
        <form method="post">
            <div class="mb-3">
                <label for="filename" class="form-label">文件名</label>
                <input type="text" class="form-control" id="filename" name="filename" required>
            </div>
            <div class="mb-3">
                <label for="filelink" class="form-label">文件链接</label>
                <input type="text" class="form-control" id="filelink" name="filelink" required>
            </div>
            <button type="submit" class="btn btn-primary">添加</button>
            <a href="admin.php" class="btn btn-secondary">返回</a>
        </form>
   
