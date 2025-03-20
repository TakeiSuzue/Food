<?php

include 'components/connect.php'; // Kết nối đến cơ sở dữ liệu

session_start(); // Bắt đầu phiên làm việc

// Kiểm tra người dùng đã đăng nhập hay chưa
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php'); // Nếu chưa đăng nhập, quay về trang chủ
};

// Xử lý khi người dùng xóa một sản phẩm khỏi giỏ hàng
if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
   $message[] = 'Đã xóa sản phẩm khỏi giỏ hàng!';
}

// Xử lý khi người dùng xóa tất cả sản phẩm trong giỏ hàng
if(isset($_POST['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   // header('location:cart.php');
   $message[] = 'Đã xóa toàn bộ giỏ hàng!';
}

// Xử lý khi người dùng cập nhật số lượng sản phẩm trong giỏ
if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING); // Lọc dữ liệu đầu vào
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'Đã cập nhật số lượng sản phẩm!';
}

$grand_total = 0; // Tổng giá trị giỏ hàng khởi tạo bằng 0

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Giỏ hàng</title>

   <!-- Link đến thư viện Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Link đến file CSS tùy chỉnh -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- Phần tiêu đề bắt đầu -->
<?php include 'components/user_header.php'; ?>
<!-- Phần tiêu đề kết thúc -->

<div class="heading">
   <h3>Giỏ hàng</h3>
   <p><a href="home.php">Trang chủ</a> <span> / Giỏ hàng</span></p>
</div>

<!-- Phần giỏ hàng bắt đầu -->

<section class="products">

   <h1 class="title">Giỏ hàng của bạn</h1>

   <div class="box-container">

      <?php
         $grand_total = 0;
         // Lấy tất cả sản phẩm trong giỏ hàng của người dùng
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch()){
      ?>
      <!-- Form cho mỗi sản phẩm -->
      <form action="" method="post" class="box">
         <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
         <!-- Xem nhanh sản phẩm -->
         <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
         <!-- Xóa sản phẩm khỏi giỏ hàng -->
         <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('Bạn có muốn xóa sản phẩm này không?');"></button>
         <!-- Hình ảnh sản phẩm -->
         <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
         <!-- Tên sản phẩm -->
         <div class="name"><?= $fetch_cart['name']; ?></div>
         <div class="flex">
            <!-- Giá sản phẩm -->
            <div class="price"><span></span><?= $fetch_cart['price']; ?>VNĐ</div>
            <!-- Số lượng sản phẩm -->
            <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
            <!-- Nút cập nhật số lượng -->
            <button type="submit" class="fas fa-edit" name="update_qty"></button>
         </div>
         <!-- Tổng giá sản phẩm này -->
         <div class="sub-total"> Thành tiền : <span><?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>VNĐ</span> </div>
      </form>
      <?php
               $grand_total += $sub_total; // Cộng vào tổng giá trị đơn hàng
            }
         }else{
            echo '<p class="empty">Giỏ hàng của bạn đang trống</p>';
         }
      ?>

   </div>

   <div class="cart-total">
      <!-- Hiển thị tổng giá trị giỏ hàng -->
      <p>Tổng tiền : <span><?= $grand_total; ?>VNĐ</span></p>
      <!-- Nút chuyển sang thanh toán -->
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">Tiến hành thanh toán</a>
   </div>

   <div class="more-btn">
      <!-- Nút xóa toàn bộ giỏ hàng -->
      <form action="" method="post">
         <button type="submit" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" name="delete_all" onclick="return confirm('Bạn có muốn xóa toàn bộ giỏ hàng không?');">Xóa tất cả</button>
      </form>
      <!-- Nút tiếp tục mua sắm -->
      <a href="menu.php" class="btn">Tiếp tục mua sắm</a>
   </div>

</section>

<!-- Phần giỏ hàng kết thúc -->

<!-- Phần footer bắt đầu -->
<?php include 'components/footer.php'; ?>
<!-- Phần footer kết thúc -->

<!-- Link đến file JS tùy chỉnh -->
<script src="js/script.js"></script>

</body>
</html>
