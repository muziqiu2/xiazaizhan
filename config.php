<?php
// 数据库连接信息
define('DB_SERVER', '数据库地址（需要加端口号）');
define('DB_USERNAME', '数据库用户名');
define('DB_PASSWORD', '数据库密码');
define('DB_NAME', '数据库名');

// 尝试连接数据库
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// 检查连接
if (!$conn) {
    die("数据库连接失败: " . mysqli_connect_error());
}
?>
