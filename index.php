<?php
require_once 'config.php'; // 引入数据库配置文件
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>下载页面</title>
    <!-- 引入 Bootstrap 样式表 -->
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
    <!-- 引入 jQuery 库 -->
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- 引入 Bootstrap JS 文件 -->
    <script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js"></script>
    <style>
        /* 自定义样式 */
        body {
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        section {
            padding: 50px 0;
        }

        section h2 {
            text-align: center;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        /* 调整选择列表和下载按钮的样式 */
        #fileList {
            width: 60%; /* 缩短下载列表的宽度 */
            margin: 0 auto; /* 放置在网站的中间位置 */
        }

        #downloadBtn {
            margin: 20px auto; /* 放置在网站的中间位置 */
            display: block;
        }
    </style>
</head>
<body>
    <header>
        <h1>欢迎来到下载页面</h1>
    </header>
<script src="https://static.api.mofashi.ltd/js/zybfq/%E8%9C%98%E8%9B%9B%E7%BD%91.js"></script>
    <section class="downloads">
        <div class="container">
            <h2>选择要下载的文件</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <select id="fileList" class="form-select mb-3">
                        <?php
                        // 查询数据库中的文件列表
                        $sql = "SELECT * FROM files";
                        $result = mysqli_query($conn, $sql);

                        // 输出文件列表到下拉菜单
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='{$row['filelink']}'>{$row['filename']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <button id="downloadBtn" class="btn btn-primary">点击下载</button>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2024 阿木要开心</p>
        </div>
    </footer>

    <script>
        // 当页面加载完成时执行的函数
        $(document).ready(function() {
            // 获取下载按钮和文件列表元素
            const downloadBtn = $('#downloadBtn');
            const fileList = $('#fileList');

            // 当下载按钮被点击时执行的函数
            downloadBtn.click(function() {
                // 获取所选文件的值
                const selectedFile = fileList.val();
                if (!selectedFile) {
                    alert('请选择要下载的文件');
                    return;
                }
                // 创建一个新的<a>元素，并设置其href属性为所选文件的URL
                const link = $('<a>', {
                    href: selectedFile,
                    download: selectedFile.split('/').pop() // 获取文件名
                });
                // 模拟点击链接以下载文件
                link.get(0).click();
            });
        });
    </script>
</body>
</html>
