<div align="center">

<h2 align="center">
    <a href="https://dainam.edu.vn/vi/khoa-cong-nghe-thong-tin">
    🎓 Faculty of Information Technology (DaiNam University)
    </a>
</h2>

## <span style="color:#333;">Management of scientific research topics</span>

<br/>

<!-- Các logo minh họa -->
<p>
  <img src="https://github.com/tyanzuq2811/BTL_Quan_ly_doan_vien/blob/main/docs/logo/aiotlab_logo.png?raw=true" width="120" style="margin: 10px;"/>
  <img src="https://github.com/tyanzuq2811/BTL_Quan_ly_doan_vien/blob/main/docs/logo/dnu_logo.png?raw=true" width="120" style="margin: 10px;"/>
  <img src="https://github.com/tyanzuq2811/BTL_Quan_ly_doan_vien/blob/main/docs/logo/fitdnu_logo.png?raw=true" width="120" style="margin: 10px;"/>
</p>

<br/>


<!-- Các badge màu -->
![AIOTLAB](https://img.shields.io/badge/AIOTLAB-green?style=for-the-badge)
![FACULTY OF INFORMATION TECHNOLOGY](https://img.shields.io/badge/Faculty%20of%20Information%20Technology-blue?style=for-the-badge)
![DAINAM UNIVERSITY](https://img.shields.io/badge/DaiNam%20University-orange?style=for-the-badge)

<br/>


<br/>

</div>
<h2 style="font-weight:normal; color:#333;">📘 1. Giới thiệu</h2>

Hệ thống Quản lý đề tài nghiên cứu khoa học trong trường đại học được xây dựng nhằm hỗ trợ công tác quản lý, theo dõi và đánh giá các hoạt động nghiên cứu khoa học của giảng viên và sinh viên. Thay vì quản lý thủ công bằng giấy tờ hoặc các tệp Excel rời rạc, hệ thống mang đến một giải pháp tập trung, hiện đại và dễ sử dụng. Ứng dụng web này giúp đơn giản hóa quy trình đăng ký, xét duyệt, theo dõi tiến độ và nghiệm thu đề tài, đồng thời tăng tính minh bạch, chính xác và hiệu quả trong công tác quản lý nghiên cứu khoa học của nhà trường.

---

## 🧰 2. Các công nghệ được sử dụng

<div align="center">

### 💻 Hệ điều hành
![MacOS](https://img.shields.io/badge/macos-black?style=for-the-badge&logo=apple)
![Windows](https://img.shields.io/badge/windows-blue?style=for-the-badge&logo=windows)
![Ubuntu](https://img.shields.io/badge/ubuntu-E95420?style=for-the-badge&logo=ubuntu&logoColor=white)

### 🧩 Công nghệ chính
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![SCSS](https://img.shields.io/badge/SCSS-CC6699?style=for-the-badge&logo=sass&logoColor=white)
![JavaScript](https://img.shields.io/badge/JAVASCRIPT-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![Bootstrap](https://img.shields.io/badge/BOOTSTRAP-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

### 🌐 Web Server & Database
![Apache](https://img.shields.io/badge/APACHE-D22128?style=for-the-badge&logo=apache&logoColor=white)
![MySQL](https://img.shields.io/badge/MYSQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![XAMPP](https://img.shields.io/badge/XAMPP-FB7A24?style=for-the-badge&logo=xampp&logoColor=white)

### 🗄️ Database Management Tools
![MySQL Workbench](https://img.shields.io/badge/MySQL%20Workbench-00758F?style=for-the-badge&logo=mysql&logoColor=white)

</div>

---

## 🚀 3. Hình ảnh các chức năng

### Trang đăng nhập
<img width="1919" height="973" alt="image" src="https://github.com/user-attachments/assets/198cd377-527d-4b64-89bd-afe476ed56b8" />



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
https://github.com/tyanzuq2811/BTL_Quan_ly_doan_vien.git
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
Hệ thống sẽ cung cấp tài khoản mặc định cho Admin (do giảng viên hướng dẫn hoặc quản trị hệ thống tạo sẵn).

Sau khi đăng nhập lần đầu, Admin có thể thực hiện các chức năng chính sau:

Tạo thông tin khoa, bộ môn, hoặc nhóm nghiên cứu (ví dụ: Khoa Công nghệ thông tin, Bộ môn Hệ thống thông tin, v.v.)

Thêm giảng viên và sinh viên vào hệ thống, đồng thời cấp tài khoản cho từng người dùng.

Phân quyền sử dụng hệ thống theo vai trò:

Admin: Quản trị toàn bộ hệ thống, phê duyệt đề tài, tạo tài khoản.

Giảng viên: Đề xuất, hướng dẫn và đánh giá đề tài.

Sinh viên: Đăng ký, chỉnh sửa, nộp và theo dõi tiến độ đề tài nghiên cứu.

Quản lý thông tin đề tài (thêm, sửa, xóa, duyệt, gán người hướng dẫn).
