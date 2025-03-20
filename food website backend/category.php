<?php

include 'components/connect.php'; // Kết nối đến cơ sở dữ liệu

session_start(); // Bắt đầu phiên làm việc (session)

// Kiểm tra người dùng đã đăng nhập chưa
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

// Nhúng file xử lý thêm vào giỏ hàng
include 'components/add_cart.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Danh mục sản phẩm</title>

   <!-- Link đến Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Link đến file CSS tùy chỉnh -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; // Nhúng header của người dùng ?>

<section class="products">

   <h1 class="title">Danh mục món ăn</h1>

   <div class="box-container">

      <?php
         // Lấy danh mục sản phẩm từ tham số GET trên URL
         $category = $_GET['category'];

         // Truy vấn các sản phẩm thuộc danh mục
         $select_products = $conn->prepare("SELECT * FROM `products` WHERE category = ?");
         $select_products->execute([$category]);

         // Kiểm tra nếu có sản phẩm thì hiển thị
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch()){
      ?>
      <!-- Form cho mỗi sản phẩm -->
      <form action="" method="post" class="box">
         <!-- Truyền thông tin sản phẩm ẩn qua form -->
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">

         <!-- Xem nhanh sản phẩm -->
         <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>

         <!-- Thêm vào giỏ hàng -->
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>

         <!-- Ảnh sản phẩm -->
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">

         <!-- Tên sản phẩm -->
         <div class="name"><?= $fetch_products['name']; ?></div>

         <div class="flex">
            <!-- Giá sản phẩm -->
            <div class="price"><?= $fetch_products['price']; ?><span>VNĐ</span></div>

            <!-- Số lượng muốn mua -->
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
      <?php
            }
         }else{
            // Nếu chưa có sản phẩm
            echo '<p class="empty">Chưa có sản phẩm nào!</p>';
         }
      ?>

   </div>

</section>
<?php include 'components/footer.php'; // Nhúng footer ?>

<!-- Link thư viện swiper slider -->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- Link file JS tùy chỉnh -->
<script src="js/script.js"></script>

</body>
</html>
