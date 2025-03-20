<?php

if(isset($_POST['add_to_cart'])){

   // Kiểm tra xem người dùng đã đăng nhập hay chưa
   if($user_id == ''){
      header('location:login.php'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
   }else{

      // Lấy dữ liệu từ form và lọc dữ liệu để an toàn hơn
      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);

      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);

      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);

      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);

      $qty = $_POST['qty'];
      $qty = filter_var($qty, FILTER_SANITIZE_STRING);

      // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      if($check_cart_numbers->rowCount() > 0){
         $message[] = 'Sản phẩm đã có trong giỏ hàng!';
      }else{
         // Thêm sản phẩm vào giỏ hàng
         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);

         $message[] = 'Đã thêm vào giỏ hàng!';
      }

   }

}

?>
