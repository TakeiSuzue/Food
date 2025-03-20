<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
   $delete_admin->execute([$delete_id]);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tài khoản quản trị viên</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- phần quản lý tài khoản quản trị viên bắt đầu -->

<section class="accounts">

   <h1 class="heading">Tài khoản quản trị viên</h1>

   <div class="box-container">

   <div class="box">
      <p>Đăng ký quản trị viên mới</p>
      <a href="register_admin.php" class="option-btn">Đăng ký</a>
   </div>

   <?php
      $select_account = $conn->prepare("SELECT * FROM `admin`");
      $select_account->execute();
      if($select_account->rowCount() > 0){
         while($fetch_accounts = $select_account->fetch()){  
   ?>
   <div class="box">
      <p> ID quản trị viên : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> Tên đăng nhập : <span><?= $fetch_accounts['name']; ?></span> </p>
      <div class="flex-btn">
         <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này không?');">Xóa</a>
         <?php
            if($fetch_accounts['id'] == $admin_id){
               echo '<a href="update_profile.php" class="option-btn">Cập nhật</a>';
            }
         ?>
      </div>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">Không có tài khoản nào!</p>';
   }
   ?>

   </div>

</section>

<!-- phần quản lý tài khoản quản trị viên kết thúc -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
