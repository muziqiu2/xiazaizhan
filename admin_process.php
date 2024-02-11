<?php
require_once 'config.php';

// 处理添加文件表单
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收表单数据
    $filename = $_POST['filename'];
    $filelink = $_POST['filelink'];

    // 插入数据到数据库
    $sql = "INSERT INTO files (filename, filelink) VALUES ('$filename', '$filelink')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('文件添加成功');</script>";
    } else {
        echo "<script>alert('文件添加失败');</script>";
    }
}
?>
