<?php
// Nếu biến $message đã được thiết lập (có thông báo cần hiển thị)
if(isset($message)){
   // Duyệt qua từng thông báo trong mảng $message
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span> <!-- Hiển thị nội dung thông báo -->
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i> <!-- Biểu tượng đóng thông báo -->
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <!-- Logo, liên kết về trang dashboard -->
      <a href="dashboard.php" class="logo">Admin<span>Panel</span></a>

      <!-- Thanh điều hướng -->
      <nav class="navbar">
         <a href="dashboard.php">Trang chủ</a>
         <a href="products.php">Sản phẩm</a>
         <a href="placed_orders.php">Đơn hàng</a>
         <a href="admin_accounts.php">Quản trị viên</a>
         <a href="users_accounts.php">Người dùng</a>
         <a href="messages.php">Tin nhắn</a>
      </nav>

      <!-- Các biểu tượng menu và tài khoản -->
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div> <!-- Nút menu -->
         <div id="user-btn" class="fas fa-user"></div> <!-- Nút người dùng -->
      </div>

      <!-- Thông tin hồ sơ quản trị viên -->
      <div class="profile">
         <?php
            // Truy vấn thông tin admin từ cơ sở dữ liệu
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch();
         ?>
         <p><?= $fetch_profile['name']; ?></p> <!-- Hiển thị tên admin -->

         <!-- Nút cập nhật hồ sơ -->
         <a href="update_profile.php" class="btn">Cập nhật hồ sơ</a>

         <!-- Nút đăng nhập và đăng ký tài khoản admin -->
         <div class="flex-btn">
            <a href="admin_login.php" class="option-btn">Đăng nhập</a>
            <a href="register_admin.php" class="option-btn">Đăng ký</a>
         </div>

         <!-- Nút đăng xuất -->
         <a href="../components/admin_logout.php" onclick="return confirm('Bạn có chắc muốn đăng xuất khỏi website này không?');" class="delete-btn">Đăng xuất</a>
      </div>

   </section>

</header>
