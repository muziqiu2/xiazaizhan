
<?php
session_start();

// 检查用户是否已经登录，如果未登录则跳转到登录页面
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
require_once 'config.php'; // 引入数据库配置文件

// 获取要编辑的文件ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('无效的文件ID');window.location='admin.php';</script>";
    exit;
}
$fileId = $_GET['id'];

// 获取文件信息
$sql = "SELECT * FROM files WHERE id = $fileId";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('未找到文件记录');window.location='admin.php';</script>";
    exit;
}
$fileInfo = mysqli_fetch_assoc($result);

// 更新文件信息
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newFilename = $_POST['filename'];
    $newFilelink = $_POST['filelink'];

    $sql = "UPDATE files SET filename='$newFilename', filelink='$newFilelink' WHERE id=$fileId";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('文件信息更新成功');window.location='admin.php';</script>";
        exit;
    } else {
        echo "<script>alert('文件信息更新失败');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑文件</title>
    <!-- 引入 Bootstrap 样式表 -->
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-5 text-center">编辑文件</h1>
        <form method="post">
            <div class="mb-3">
                <label for="filename" class="form-label">文件名</label>
                <input type="text" class="form-control" id="filename" name="filename" value="<?php echo $fileInfo['filename']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="filelink" class="form-label">文件链接</label>
                <input type="text" class="form-control" id="filelink" name="filelink" value="<?php echo $fileInfo['filelink']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">保存</button>
            <a href="admin.php" class="btn btn-secondary">返回</a>
        </form>
    </div>
</body>
</html>
