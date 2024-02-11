-- 创建 users 表用于存储用户信息
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- 创建 files 表用于存储文件信息
CREATE TABLE IF NOT EXISTS files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(100) NOT NULL,
    filelink VARCHAR(255) NOT NULL
);

-- 添加默认用户 admin
INSERT INTO users (username, password) VALUES ('admin', 'admin');

-- 添加默认下载文件
INSERT INTO files (filename, filelink) VALUES 
('SampleFile1.zip', 'https://example.com/downloads/samplefile1.zip'),
('SampleFile2.rar', 'https://example.com/downloads/samplefile2.rar');
