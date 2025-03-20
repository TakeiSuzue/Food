<?php

include 'components/connect.php';

session_start();

// Kiểm tra nếu người dùng đã đăng nhập
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php'); // Nếu chưa đăng nhập thì quay về trang chủ
};

if(isset($_POST['submit'])){

   // Lấy dữ liệu từ form và lọc dữ liệu
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   // Kiểm tra giỏ hàng có sản phẩm không
   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      if($address == ''){
         $message[] = 'vui lòng thêm địa chỉ giao hàng!';
      }else{
         // Thêm đơn hàng vào cơ sở dữ liệu
         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         // Xóa giỏ hàng sau khi đặt hàng
         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'đặt hàng thành công!';
      }
      
   }else{
      $message[] = 'giỏ hàng của bạn đang trống';
   }

}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thanh toán</title>

   <!-- liên kết font awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- liên kết css tùy chỉnh -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- phần đầu trang bắt đầu -->
<?php include 'components/user_header.php'; ?>
<!-- phần đầu trang kết thúc -->

<div class="heading">
   <h3>Thanh toán</h3>
   <p><a href="home.php">Trang chủ</a> <span> / Thanh toán</span></p>
</div>

<section class="checkout">

   <h1 class="title">Tóm tắt đơn hàng</h1>

<form action="" method="post">

   <div class="cart-items">
      <h3>Sản phẩm trong giỏ</h3>
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch()){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
      <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price"><?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?>VNĐ</span></p>
      <?php
            }
         }else{
            echo '<p class="empty">giỏ hàng của bạn đang trống!</p>';
         }
      ?>
      <p class="grand-total"><span class="name">Tổng cộng :</span><span class="price"><?= $grand_total; ?>VNĐ</span></p>
      <a href="cart.php" class="btn">Xem giỏ hàng</a>
   </div>

   <input type="hidden" name="total_products" value="<?= $total_products; ?>">
   <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
   <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
   <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
   <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

   <div class="user-info">
      <h3>Thông tin của bạn</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
      <a href="update_profile.php" class="btn">Cập nhật thông tin</a>
      <h3>Địa chỉ giao hàng</h3>
      <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'Vui lòng nhập địa chỉ giao hàng';}else{echo $fetch_profile['address'];} ?></span></p>
      <a href="update_address.php" class="btn">Cập nhật địa chỉ</a>
      <select name="method" class="box" required>
         <option value="" disabled selected>Chọn phương thức thanh toán --</option>
         <option value="cash on delivery">Thanh toán khi nhận hàng</option>
         <option value="credit card">Thẻ tín dụng</option>
         <option value="paytm">Paytm</option>
         <option value="paypal">Paypal</option>
      </select>
      <input type="submit" value="Đặt hàng" class="btn <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
   </div>

</form>
   
</section>

<!-- phần chân trang bắt đầu -->
<?php include 'components/footer.php'; ?>
<!-- phần chân trang kết thúc -->

<!-- liên kết file js tùy chỉnh -->
<script src="js/script.js"></script>

</body>
</html>
