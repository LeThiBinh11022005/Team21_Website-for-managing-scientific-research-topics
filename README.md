<h2 align="center">
    <a href="https://dainam.edu.vn/vi/khoa-cong-nghe-thong-tin">
    🎓 Faculty of Information Technology (DaiNam University)
    </a>
</h2>
<h2 align="center">
    Open Source Software Development
</h2>
<div align="center">
    <p align="center">
        <img src="docs/logo/aiotlab_logo.png" alt="AIoTLab Logo" width="170"/>
        <img src="docs/logo/fitdnu_logo.png" alt="AIoTLab Logo" width="180"/>
        <img src="docs/logo/dnu_logo.png" alt="DaiNam University Logo" width="200"/>
    </p>

[![AIoTLab](https://img.shields.io/badge/AIoTLab-green?style=for-the-badge)](https://www.facebook.com/DNUAIoTLab)
[![Faculty of Information Technology](https://img.shields.io/badge/Faculty%20of%20Information%20Technology-blue?style=for-the-badge)](https://dainam.edu.vn/vi/khoa-cong-nghe-thong-tin)
[![DaiNam University](https://img.shields.io/badge/DaiNam%20University-orange?style=for-the-badge)](https://dainam.edu.vn)


</div>
<h2> 📖 1. Giới thiệu</h2>
Hệ thống quản lý đề tài nghiên cứu khoa học trong môi trường giáo dục đại học được xây dựng nhằm hỗ trợ công tác quản lý, theo dõi và đánh giá các đề tài nghiên cứu khoa học của sinh viên và giảng viên. Thay vì sử dụng các phương thức quản lý thủ công bằng giấy tờ hay các tệp Excel rời rạc, hệ thống mang đến một giải pháp tập trung, hiện đại và dễ sử dụng, giúp các bên liên quan (giảng viên, sinh viên, ban quản lý khoa) dễ dàng theo dõi tiến độ, kết quả nghiên cứu và các hoạt động liên quan đến các đề tài nghiên cứu. Được phát triển trong học phần Phát triển mã nguồn mở, ứng dụng sử dụng các công nghệ và phương pháp lập trình hiện đại, góp phần nâng cao hiệu quả trong việc tổ chức và quản lý các hoạt động nghiên cứu khoa học tại trường đại học.

## 🔧 2. Các công nghệ được sử dụng
<div align="center">

### Hệ điều hành
![macOS](https://img.shields.io/badge/macOS-000000?style=for-the-badge&logo=macos&logoColor=F0F0F0)
[![Windows](https://img.shields.io/badge/Windows-0078D6?style=for-the-badge&logo=windows&logoColor=white)](https://www.microsoft.com/en-us/windows/)
[![Ubuntu](https://img.shields.io/badge/Ubuntu-E95420?style=for-the-badge&logo=ubuntu&logoColor=white)](https://ubuntu.com/)

### Công nghệ chính
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](#)
[![CSS](https://img.shields.io/badge/CSS-1572B6?style=for-the-badge&logo=css3&logoColor=white)](#)
[![SCSS](https://img.shields.io/badge/SCSS-CC6699?style=for-the-badge&logo=sass&logoColor=white)](#)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](#)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com/)

### Web Server & Database
[![Apache](https://img.shields.io/badge/Apache-D22128?style=for-the-badge&logo=apache&logoColor=white)](https://httpd.apache.org/)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/) 
[![XAMPP](https://img.shields.io/badge/XAMPP-FB7A24?style=for-the-badge&logo=xampp&logoColor=white)](https://www.apachefriends.org/)

### Database Management Tools
[![MySQL Workbench](https://img.shields.io/badge/MySQL_Workbench-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://dev.mysql.com/downloads/workbench/)
</div>

## 🚀 3. Hình ảnh các chức năng
### Trang đăng nhập
<img width="1919" height="973" alt="image" src="https://github.com/user-attachments/assets/39503b5b-28a9-4c22-8f5b-4db5c102775b" />

## ⚙️ 4. Cài đặt

### 4.1. Cài đặt công cụ, môi trường và các thư viện cần thiết

- Tải và cài đặt **XAMPP**  
  👉 https://www.apachefriends.org/download.html  
  (Khuyến nghị bản XAMPP với PHP 8.x)

- Cài đặt **Visual Studio Code** và các extension:
  - PHP Intelephense  
  - MySQL  
  - Prettier – Code Formatter  
### 4.2. Tải project
Clone project về thư mục `htdocs` của XAMPP (ví dụ ổ C):

```bash
cd C:\xampp\htdocs
https://github.com/
Truy cập project qua đường dẫn:
👉 http://localhost/authentication_login.
```
### 4.3. Setup database
Mở XAMPP Control Panel, Start Apache và MySQL

Truy cập MySQL WorkBench
Tạo database:
```bash
CREATE DATABASE IF NOT EXISTS quan_ly_doan_vien
   CHARACTER SET utf8mb4
   COLLATE utf8mb4_unicode_ci;
```

### 4.4. Setup tham số kết nối
Mở file config.php (hoặc .env) trong project, chỉnh thông tin DB:
```bash

<?php

function getDbConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "210925";
    $dbname = "qlydetai";
    $port = 3306;

    // Tạo kết nối
    $conn = mysqli_connect($servername, $username, $password, $dbname, $port);

    // Kiểm tra kết nối
    if (!$conn) {
        die("Kết nối database thất bại: " . mysqli_connect_error());
    }
    // Thiết lập charset cho kết nối (quan trọng để hiển thị tiếng Việt đúng)
    mysqli_set_charset($conn, "utf8");
    return $conn;
}

?>
```
### 4.5. Chạy hệ thống
Mở XAMPP Control Panel → Start Apache và MySQL

Truy cập hệ thống:
👉 http://localhost/index.php

### 4.6. Đăng nhập lần đầu
Tạo và quản lý đề tài nghiên cứu: Admin có thể tạo mới, chỉnh sửa và theo dõi tiến độ các đề tài nghiên cứu, bao gồm thông tin đề tài, giảng viên hướng dẫn, sinh viên tham gia, và thời gian thực hiện.

Thêm và cấp tài khoản người dùng: Admin có thể thêm giảng viên và sinh viên, cấp tài khoản và phân quyền truy cập phù hợp với từng vai trò (Giảng viên, Sinh viên).

Quản lý phân quyền người dùng: Admin phân quyền chi tiết theo vai trò:

Giảng viên: Quản lý đề tài, theo dõi tiến độ, và đánh giá kết quả nghiên cứu.

Sinh viên: Cập nhật tiến độ nghiên cứu, nộp tài liệu và nhận phản hồi từ giảng viên.

Quản lý tài liệu và tiến độ: Cho phép giảng viên và sinh viên tải lên tài liệu nghiên cứu, cập nhật tiến độ và nhận xét, phản hồi.

Thông báo và nhắc nhở: Gửi thông báo về các mốc thời gian quan trọng, nhắc nhở tiến độ nghiên cứu và các sự kiện liên quan.
