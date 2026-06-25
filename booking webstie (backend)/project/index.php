<?php
include 'components/controllers/index_controller.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="home" id="home">

   <div class="swiper home-slider">

      <div class="swiper-wrapper">

         <div class="box swiper-slide">
            <img src="images/home-img-1.jpg" alt="">
            <div class="flex">
               <h3>A/C rooms</h3>
               <a href="#availability" class="btn">check availability</a>
            </div>
         </div>

         <div class="box swiper-slide">
            <img src="images/gallery-img-5.jpg" alt="">
            <div class="flex">
               <h3>Foods and drinks</h3>
               <a href="#reservation" class="btn">make a reservation</a>
            </div>
         </div>

         <div class="box swiper-slide">
            <img src="images/home-img-3.jpg" alt="">
            <div class="flex">
               <h3> Hall</h3>
               <a href="#contact" class="btn">contact us</a>
            </div>
         </div>

      </div>

      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>

   </div>

</section>

<section class="availability" id="availability">

   <form action="" method="post">
      <div class="flex">
         <div class="box">
            <p>check in <span>*</span></p>
            <input type="date" name="check_in" class="input" required>
         </div>
         <div class="box">
            <p>check out <span>*</span></p>
            <input type="date" name="check_out" class="input" required>
         </div>
         <div class="box">
            <p>adults <span>*</span></p>
            <select name="adults" class="input" required>
               <option value="1">1 adult</option>
               <option value="2">2 adults</option>
               <option value="3">3 adults</option>
               <option value="4">4 adults</option>
               <option value="5">5 adults</option>
               <option value="6">6 adults</option>
            </select>
         </div>
         <div class="box">
            <p>childs <span>*</span></p>
            <select name="childs" class="input" required>
               <option value="-">0 child</option>
               <option value="1">1 child</option>
               <option value="2">2 childs</option>
               <option value="3">3 childs</option>
               <option value="4">4 childs</option>
               <option value="5">5 childs</option>
               <option value="6">6 childs</option>
            </select>
         </div>
         <div class="box">
            <p>rooms <span>*</span></p>
            <select name="rooms" class="input" required>
               <option value="1">1 room</option>
               <option value="2">2 rooms</option>
               <option value="3">3 rooms</option>
               <option value="4">4 rooms</option>
               <option value="5">5 rooms</option>
               <option value="6">6 rooms</option>
            </select>
         </div>
      </div>
      <input type="submit" value="check availability" name="check" class="btn">
   </form>

</section>

<section class="about" id="about">

   <div class="row">
      <div class="image">
         <img src="images/anu1.jpeg" alt="">
      </div>
      <div class="content">
         <h3>Our Purpose</h3>
         <p>To build a just, sustainable, compassionate social order that fulfils the basic human needs of the community through individual and collective awakening.</p>
         <a href="#reservation" class="btn">make a reservation</a>
      </div>
   </div>

   <div class="row revers">
      <div class="image">
         <img src="images/food.jpg" alt="">
      </div>
      <div class="content">
         <h3>best foods</h3>
         <p>The restaurant specialises in Jaffna and South Indian Tamil cuisine, and standouts include the crab curry, the huge breakfast dosas, the mutton biriyani and Odyal Kool, a thick seafood soup – though plenty of western dishes are also on the menu. Depending on hotel occupancy, the restaurant serves a set menu or a buffet, with à la carte always available. The buffet offers good local and international dishes (no beef or pork), though the desserts were disappointing</p>
         <a href="#contact" class="btn">contact us</a>
      </div>
   </div>

   <div class="row">
      <div class="image">
         <img src="images/123.png" alt="">
      </div>
      <div class="content">
         <h3>swimming pool</h3>
         <p>A pool offers a low-impact workout, so you can exercise without putting a lot of pressure on your joints.</p>
         <a href="#availability" class="btn">check availability</a>
      </div>
   </div>

</section>

<section class="services">

   <div class="box-container">

      <div class="box">
         <img src="images/icon-1.png" alt="">
         <h3>food & drinks</h3>
         <p>delicious, aromatic, yummy, flavorful, appetizing, mouth-watering, luscious, tender, and scrumptious</p>
      </div>

      <div class="box">
         <img src="images/icon-2.png" alt="">
         <h3>outdoor dining</h3>
         <p>Outdoor dining areas serving alcoholic beverages shall be continuously supervised by employees of the establishment.</p>
      </div>

      <div class="box">
         <img src="images/icon-3.png" alt="">
         <h3>beach view</h3>
         <p>We give stress free place </p>
      </div>

      <div class="box">
         <img src="images/icon-4.png" alt="">
         <h3>decorations</h3>
         <p>The room looked amazing. It was a pleasure dealing with you, you made it very easy for you.</p>
      </div>

      <div class="box">
         <img src="images/icon-5.png" alt="">
         <h3>swimming pool</h3>
         <p>A pool offers a low-impact workout, so you can exercise without putting a lot of pressure on your joints.</p>
      </div>

      <div class="box">
         <img src="images/icon-6.png" alt="">
         <h3>resort beach</h3>
         <p>We give stress free place</p>
      </div>

   </div>

</section>
<!-- dynamic rooms section starts -->
<section class="rooms" id="rooms">

   <h1 class="heading">our luxury rooms</h1>

   <div class="rooms-grid">
      <?php
         $select_rooms = $conn->prepare("SELECT * FROM `rooms` WHERE status = 'available'");
         $select_rooms->execute();
         if($select_rooms->rowCount() > 0){
            while($fetch_room = $select_rooms->fetch(PDO::FETCH_ASSOC)){
               $amenities_arr = explode(',', $fetch_room['amenities']);
      ?>
      <div class="room-card">
         <div class="room-image">
            <img src="images/<?= $fetch_room['image']; ?>" alt="<?= $fetch_room['name']; ?>">
            <div class="room-price">$<?= $fetch_room['price']; ?> / Night</div>
         </div>
         <div class="room-content">
            <h3 class="room-title"><?= $fetch_room['name']; ?></h3>
            <p class="room-desc"><?= $fetch_room['description']; ?></p>
            <div class="room-specs">
               <span><i class="fas fa-bed"></i> <?= $fetch_room['type']; ?></span>
               <span><i class="fas fa-users"></i> Max <?= $fetch_room['capacity_adults']; ?> Guests</span>
            </div>
            <div class="room-amenities">
               <?php foreach($amenities_arr as $amenity){ ?>
                  <span class="amenity-tag"><?= trim($amenity); ?></span>
               <?php } ?>
            </div>
            <a href="#reservation" class="btn book-room-btn" data-room-id="<?= $fetch_room['id']; ?>" data-room-price="<?= $fetch_room['price']; ?>" style="display: block; text-align: center; width: 100%;">Book Room</a>
         </div>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty" style="text-align:center; width:100%; font-size:1.8rem; color:var(--text-muted);">No luxury rooms available at the moment!</p>';
         }
      ?>
   </div>

</section>
<!-- dynamic rooms section ends -->

<!-- reservation section starts -->
<section class="reservation" id="reservation">

   <form action="" method="post" id="reservation_form">
      <h3>make a reservation</h3>
      <div class="flex">
         <div class="box">
            <p>select room <span>*</span></p>
            <select name="room_id" id="room_id" class="input" required>
               <option value="" disabled selected>-- select room type --</option>
               <?php
                  $select_rooms_list = $conn->prepare("SELECT * FROM `rooms` WHERE status = 'available'");
                  $select_rooms_list->execute();
                  while($room_item = $select_rooms_list->fetch(PDO::FETCH_ASSOC)){
                     echo '<option value="'.$room_item['id'].'" data-price="'.$room_item['price'].'">'.$room_item['name'].' ($'.$room_item['price'].'/night)</option>';
                  }
               ?>
            </select>
         </div>
         <div class="box">
            <p>your name <span>*</span></p>
            <input type="text" name="name" maxlength="50" required placeholder="enter your name" class="input">
         </div>
         <div class="box">
            <p>your email <span>*</span></p>
            <input type="email" name="email" maxlength="50" required placeholder="enter your email" class="input">
         </div>
         <div class="box">
            <p>your number <span>*</span></p>
            <input type="number" name="number" maxlength="10" min="0" max="9999999999" required placeholder="enter your number" class="input">
         </div>
         <div class="box">
            <p>rooms count <span>*</span></p>
            <select name="rooms" id="rooms_count" class="input" required>
               <option value="1" selected>1 room</option>
               <option value="2">2 rooms</option>
               <option value="3">3 rooms</option>
               <option value="4">4 rooms</option>
               <option value="5">5 rooms</option>
               <option value="6">6 rooms</option>
            </select>
         </div>
         <div class="box">
            <p>check in <span>*</span></p>
            <input type="date" name="check_in" id="check_in" class="input" required>
         </div>
         <div class="box">
            <p>check out <span>*</span></p>
            <input type="date" name="check_out" id="check_out" class="input" required>
         </div>
         <div class="box">
            <p>adults <span>*</span></p>
            <select name="adults" class="input" required>
               <option value="1" selected>1 adult</option>
               <option value="2">2 adults</option>
               <option value="3">3 adults</option>
               <option value="4">4 adults</option>
               <option value="5">5 adults</option>
               <option value="6">6 adults</option>
            </select>
         </div>
         <div class="box">
            <p>childs <span>*</span></p>
            <select name="childs" class="input" required>
               <option value="0" selected>0 child</option>
               <option value="1">1 child</option>
               <option value="2">2 childs</option>
               <option value="3">3 childs</option>
               <option value="4">4 childs</option>
               <option value="5">5 childs</option>
               <option value="6">6 childs</option>
            </select>
         </div>
      </div>
      
      <div class="price-preview-box" id="price_preview_box">
         <p>Estimated Net Total</p>
         <div class="price-amount" id="total_estimated_price">$0</div>
      </div>

      <input type="submit" value="book now" name="book" class="btn" style="width: 100%; margin-top: 1.5rem;">
   </form>

</section>
<!-- reservation section ends -->

<section class="gallery" id="gallery">

   <div class="swiper gallery-slider">
      <div class="swiper-wrapper">
         <img src="images/gallery-img-1.jpg" class="swiper-slide" alt="">
         <img src="images/gallery-img-2.webp" class="swiper-slide" alt="">
         <img src="images/gallery-img-3.webp" class="swiper-slide" alt="">
         <img src="images/gallery-img-4.webp" class="swiper-slide" alt="">
         <img src="images/gallery-img-5.webp" class="swiper-slide" alt="">
         <img src="images/gallery-img-6.webp" class="swiper-slide" alt="">
      </div>
      <div class="swiper-pagination"></div>
   </div>

</section>

<section class="contact" id="contact">

   <div class="row">

      <form action="" method="post">
         <h3>send us message</h3>
         <input type="text" name="name" required maxlength="50" placeholder="enter your name" class="box">
         <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
         <input type="number" name="number" required maxlength="10" min="0" max="9999999999" placeholder="enter your number" class="box">
         <textarea name="message" class="box" required maxlength="1000" placeholder="enter your message" cols="30" rows="10"></textarea>
         <input type="submit" value="send message" name="send" class="btn">
      </form>

      <div class="faq">
         <h3 class="title">frequently asked questions</h3>
         <div class="box active">
            <h3>How to cancel?</h3>
            <p>If you want to cancel the booking first go to the my booking page then click cancel booking</p>
         </div>
         <div class="box">
            <h3>Is there any vacancy?</h3>
            <p>Currently we dont have vacancies,if any possibilites we update here</p>
         </div>
         <div class="box">
            <h3>what are payment methods?</h3>
            <p>You can pay the money directly in our recieption / transfer the payment via online 
               (Account holder - s.vaishnavi , Ac No- 71234683, Commercial bank jaffna branch)
            </p>
         </div>
         <div class="box">
            <h3></h3>
            <p>
            </p>
         </div>
      </div>

   </div>

</section>

<section class="reviews" id="reviews">

   <div class="swiper reviews-slider">

      <div class="swiper-wrapper">
         <div class="swiper-slide box">
            <img src="images/pic-1.png" alt="">
            <h3>john deo</h3>
            <p>Good quality , satisfied about your service </p>
         </div>
         <div class="swiper-slide box">
            <img src="images/pic-2.png" alt="">
            <h3>john deo</h3>
            <p>Good quality , satisfied about your service</p>
         </div>
         <div class="swiper-slide box">
            <img src="images/pic-3.png" alt="">
            <h3>john deo</h3>
            <p>Good quality , satisfied about your service</p>
         </div>
         <div class="swiper-slide box">
            <img src="images/pic-4.png" alt="">
            <h3>john deo</h3>
            <p>Good quality , satisfied about your service</p>
         </div>
         <div class="swiper-slide box">
            <img src="images/pic-5.png" alt="">
            <h3>john deo</h3>
            <p>Good quality , satisfied about your service</p>
         </div>
         <div class="swiper-slide box">
            <img src="images/pic-6.png" alt="">
            <h3>john deo</h3>
            <p>Good quality , satisfied about your service</p>
         </div>
      </div>

      <div class="swiper-pagination"></div>
   </div>

</section>





<?php include 'components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

<script>
  var swiper = new Swiper(".gallery-slider", {
    loop: true,
    autoplay: {
      delay: 3000, // 3 seconds
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    speed: 800,
    spaceBetween: 20,
    slidesPerView: 1,
  });

  // Scroll to reservation and pre-select room when Book Room button is clicked
  document.querySelectorAll('.book-room-btn').forEach(btn => {
     btn.addEventListener('click', function(e) {
        e.preventDefault();
        const roomId = this.getAttribute('data-room-id');
        const roomSelect = document.getElementById('room_id');
        if (roomSelect) {
           roomSelect.value = roomId;
           roomSelect.dispatchEvent(new Event('change'));
        }
        const reservationSection = document.getElementById('reservation');
        if (reservationSection) {
           reservationSection.scrollIntoView({ behavior: 'smooth' });
        }
     });
  });

  // Estimated Price Calculator
  const roomIdSelect = document.getElementById('room_id');
  const checkInInput = document.getElementById('check_in');
  const checkOutInput = document.getElementById('check_out');
  const roomsCountSelect = document.getElementById('rooms_count');
  const pricePreviewBox = document.getElementById('price_preview_box');
  const totalEstimatedPrice = document.getElementById('total_estimated_price');

  function calculateEstimate() {
     if (!roomIdSelect || !checkInInput || !checkOutInput || !roomsCountSelect) return;
     
     const selectedOption = roomIdSelect.options[roomIdSelect.selectedIndex];
     if (!selectedOption || roomIdSelect.value === "") {
        pricePreviewBox.style.display = 'none';
        return;
     }
     
     const pricePerNight = parseFloat(selectedOption.getAttribute('data-price'));
     const checkInVal = checkInInput.value;
     const checkOutVal = checkOutInput.value;
     const roomsCount = parseInt(roomsCountSelect.value) || 1;
     
     if (checkInVal && checkOutVal) {
        const date1 = new Date(checkInVal);
        const date2 = new Date(checkOutVal);
        const timeDiff = date2.getTime() - date1.getTime();
        const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
        
        if (daysDiff > 0 && pricePerNight > 0) {
           const totalPrice = pricePerNight * roomsCount * daysDiff;
           totalEstimatedPrice.textContent = '$' + totalPrice.toLocaleString();
           pricePreviewBox.style.display = 'block';
        } else {
           pricePreviewBox.style.display = 'none';
        }
     } else {
        pricePreviewBox.style.display = 'none';
     }
  }

  if (roomIdSelect) roomIdSelect.addEventListener('change', calculateEstimate);
  if (checkInInput) checkInInput.addEventListener('change', calculateEstimate);
  if (checkOutInput) checkOutInput.addEventListener('change', calculateEstimate);
  if (roomsCountSelect) roomsCountSelect.addEventListener('change', calculateEstimate);
</script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

</body>
</html>