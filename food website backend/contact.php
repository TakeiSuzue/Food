<?php

include 'components/connect.php'; // Kết nối cơ sở dữ liệu

session_start(); // Bắt đầu phiên làm việc

// Kiểm tra người dùng đã đăng nhập chưa
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   // Lấy dữ liệu từ form và lọc dữ liệu
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   // Kiểm tra tin nhắn đã tồn tại chưa
   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'Bạn đã gửi tin nhắn này rồi!';
   }else{
      // Thêm tin nhắn mới vào cơ sở dữ liệu
      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'Gửi tin nhắn thành công!';
   }

}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Liên hệ</title>

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
   <h3>Liên hệ với chúng tôi</h3>
   <p><a href="home.php">Trang chủ</a> <span> / Liên hệ</span></p>
</div>

<!-- phần liên hệ bắt đầu -->

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>

      <form action="" method="post">
         <h3>Hãy cho chúng tôi biết điều gì đó!</h3>
         <input type="text" name="name" maxlength="50" class="box" placeholder="Nhập tên của bạn" required>
         <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="Nhập số điện thoại của bạn" required maxlength="10">
         <input type="email" name="email" maxlength="50" class="box" placeholder="Nhập email của bạn" required>
         <textarea name="msg" class="box" required placeholder="Nhập tin nhắn của bạn" maxlength="500" cols="30" rows="10"></textarea>
         <input type="submit" value="Gửi tin nhắn" name="send" class="btn">
      </form>

   </div>

</section>

<!-- phần liên hệ kết thúc -->

<!-- phần chân trang bắt đầu -->
<?php include 'components/footer.php'; ?>
<!-- phần chân trang kết thúc -->

<!-- liên kết file js -->
<script src="js/script.js"></script>

</body>
</html>
