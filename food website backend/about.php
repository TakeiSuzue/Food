<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="vi"> <!-- đổi lang từ 'en' sang 'vi' -->
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Về chúng tôi</title> <!-- dịch tiêu đề -->

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- phần tiêu đề bắt đầu -->
<?php include 'components/user_header.php'; ?>
<!-- phần tiêu đề kết thúc -->

<div class="heading">
   <h3>về chúng tôi</h3>
   <p><a href="home.php">Trang chủ</a> <span> / Về chúng tôi</span></p>
</div>

<!-- phần giới thiệu bắt đầu -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>Tại sao chọn chúng tôi?</h3>
         <p>
         ❀ Nguyên liệu chất lượng. <br>
         ❀ Thực đơn sáng tạo. <br>
         ❀ Tỉ mỉ trong từng chi tiết. <br>
         ❀ Dịch vụ khách hàng tuyệt vời. <br>
         ❀ Đảm bảo độ tươi ngon. <br>
         ❀ Ưu tiên địa phương và theo mùa. <br>
         ❀ Không gian và bầu không khí thoải mái. <br>
         ❀ Gắn kết cộng đồng. <br>
         ❀ Tùy chỉnh theo yêu cầu. <br>
      </p>
         <a href="menu.php" class="btn">Thực đơn của chúng tôi</a>
      </div>

   </div>

</section>

<!-- phần giới thiệu kết thúc -->

<!-- phần các bước bắt đầu -->

<section class="steps">

   <h1 class="title">Các bước đơn giản</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/step-1.png" alt="">
         <h3>Chọn món</h3>
         <p>Thưởng thức các loại bánh thủ công, bánh ngọt hấp dẫn và bánh sinh nhật theo yêu cầu, được làm bằng tình yêu và sự khéo léo.</p>
      </div>

      <div class="box">
         <img src="images/step-2.png" alt="">
         <h3>Giao hàng nhanh chóng</h3>
         <p>Nhận hàng nhanh và an toàn! Thưởng thức các món ngon của chúng tôi ngay tại nhà bạn, tươi mới và đảm bảo chất lượng.</p>
      </div>

      <div class="box">
         <img src="images/step-3.png" alt="">
         <h3>Thưởng thức món ngon</h3>
         <p>Tự thưởng cho mình những món ngon tuyệt vời! Mỗi miếng bánh là một hương vị tuyệt hảo được chọn lọc từ nguyên liệu tốt nhất.</p>
      </div>

   </div>

</section>

<!-- phần các bước kết thúc -->

<!-- phần đánh giá bắt đầu -->

<section class="reviews">

   <h1 class="title"><mark>Đánh giá của khách hàng</mark></h1>

   <div class="swiper reviews-slider">

      <div class="swiper-wrapper">

         <div class="swiper-slide slide">
            <img src="images/pic-1.jpg" alt="">
            <p>Thật tuyệt vời! Bánh quế quế rất ngon và bánh sô cô la tan chảy trong miệng. Giao hàng nhanh chóng, chắc chắn sẽ đặt lần nữa!</p>
            <div class="stars">
               <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Aditya.</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/pic-2.jpg" alt="">
            <p>Bánh croissant giòn và bánh carrot cực mềm, mỗi miếng cắn đều tuyệt vời. Giao hàng nhanh và đóng gói rất cẩn thận. Rất đáng để thử!</p>
            <div class="stars">
               <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Chandan.</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/pic-3.jpg" alt="">
            <p>Hương vị tuyệt vời và dịch vụ hoàn hảo! Bánh cookies rất gây nghiện và bánh cheesecake thật sự là đỉnh cao. Sẽ quay lại mua tiếp!</p>
            <div class="stars">
               <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Monika.</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/pic-4.jpg" alt="">
            <p>Bánh sourdough hoàn hảo, bánh tart trái cây như ánh nắng rực rỡ. Giao hàng đúng giờ, tất cả đều giữ nguyên vẹn khi nhận.</p>
            <div class="stars">
               <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Ankit.</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/pic-5.jpg" alt="">
            <p>Thật ngon! Bánh ngọt mềm mại và bánh sinh nhật được làm theo yêu cầu là điểm nhấn. Giao hàng nhanh và an toàn. Cả gia đình tôi đều mê!</p>
            <div class="stars">
               <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Raj.</h3>
         </div>

         <div class="swiper-slide slide">
            <img src="images/pic-6.jpg" alt="">
            <p>Những món ngọt tuyệt vời! Bánh brownie dẻo thơm, các loại muffin cũng rất ngon. Giao hàng siêu nhanh, bánh đến nơi vẫn còn mới tinh!</p>
            <div class="stars">
               <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <h3>Sneha.</h3>
         </div>

      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

<!-- phần đánh giá kết thúc -->

<!-- phần chân trang bắt đầu -->
<?php include 'components/footer.php'; ?>
<!-- phần chân trang kết thúc -->

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- file js tuỳ chỉnh -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   grabCursor: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
      slidesPerView: 1,
      },
      700: {
      slidesPerView: 2,
      },
      1024: {
      slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>
