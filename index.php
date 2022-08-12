<?php
session_start();
require_once './__assignSession.php';
require_once './__connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="./style/style.css">
   <link rel="stylesheet" href="./style/header-navigationBar.css">
   <link rel="stylesheet" href="./style/header-slider.css">
   <link rel="stylesheet" href="./style/recommendation.css">
   <link rel="stylesheet" href="./style/explore.css">
   <link rel="stylesheet" href="./style/activity.css">
   <link rel="stylesheet" href="./style/footer.css">
   <link rel="stylesheet" href="./style/admin-jobs.css">
   <link rel="icon" href="./style/assests/travel.png">
   <title>Tourist Guide | Home</title>
</head>

<body>

   <script>
      function confrimlogout() {
         const confrimation = confirm('Are you sure you wanna logout?');
         if (confrimation) {
            location.href = './logout.php';
         }
      }
   </script>

   <header>
      <?php require_once './__navigationBar.php'; ?>

      <div class="slideshow-container">
         <div class="shade-slides"></div>

         <?php
         $countOfRecomendations = 3;
         include './__recommendations.php' ?>

         <?php foreach ($recomendationOfPosts as $index => $post) { ?>
            <div class="slides fade">
               <img src="<?php echo "./images/posts/" . $post['image']; ?>">
               <div class="img-info">
                  <h3><?php echo $post['title'] ?></h3>
                  <p><?php echo substr($post['description'], 0, 220) . "..." ?><a href="<?php echo "./individualPage.php?id=" . $post['id'] ?>" style="color:var(--blue); text-decoration:underline;">more</a></p>
               </div>
            </div>
         <?php } ?>

         <!-- <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
         <a class="next" onclick="plusSlides(1)">&#10095;</a> -->

         <div class="slides-navigator">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
         </div>
      </div>

   </header>

   <hr>
   <div class="recommendation">
      <h2>Featured by Passion Seekers</h2>
      <ul class="recommendation__list">
         <?php
         $countOfRecomendations = 4;
         include './__recommendations.php';
         ?>

         <?php foreach ($recomendationOfPosts as $recPost) { ?>
            <li class="recommendation__list__item">
               <a href="<?php echo "./individualPage.php?id=" . $recPost['id']; ?>">
                  <div class="recommendation__list__item_images">
                     <img src="<?php echo './images/posts/' . $recPost['image'] ?>" alt="#">
                  </div>
               </a>
               <div class="recommendation__list__item_info">
                  <span class="tag"><?php echo $recPost['username']; ?></span>
                  <h4><?php echo $recPost['title']; ?></h4>
                  <p><?php echo substr($recPost['description'], 0, 150) ?>...<a href="<?php echo "./individualPage.php?id=" . $recPost['id']; ?>" class="recommendation__list__item_more">more</a></p>
               </div>
            </li>
         <?php } ?>
      </ul>
   </div>

   <hr>
   <div class="explore">
      <?php //echo mysqlGetPostsForExploreAndActivities('explore'); 
      ?>
      <h2>Explore</h2>
      <div class="explore_content">
         <div class="explore_content_blogs">

            <?php
            $queryToGetExplore = mysqlGetPostsForExploreAndActivities('explore');
            $activitiesForExplore = $connection->query($queryToGetExplore);
            $arrayOfLocationExplore = [];

            while ($row = $activitiesForExplore->fetch_assoc()) {
               array_push($arrayOfLocationExplore, $row);
            }
            ?>

            <?php
            if (count($arrayOfLocationExplore) >= 11) {
               foreach ($arrayOfLocationExplore as $index => $location) {
                  if ($index == 2 || $index == 3 || $index == 6) {
            ?>
                     <div class="explore_content_blog explore_content_blog--big">
                        <div class="explore_content_blog_image">
                           <img src="<?php echo './images/posts/' . $location['image'] ?>" alt="image">
                        </div>

                        <div class="explore_content_blog_info">
                           <h2><?php echo $location['title']; ?></h2>
                           <p><?php echo substr($location['description'], 0, 180) . "..." ?><a href="<?php echo "./individualPage.php?id=" . $location['id'] ?>" style="color:var(--blue); text-decoration:underline;">more</a></p>
                        </div>
                     </div>
                  <?php
                  } else {
                  ?>
                     <div class="explore_content_blog">
                        <div class="explore_content_blog_image">
                           <img src="<?php echo './images/posts/' . $location['image'] ?>" alt="image">
                        </div>

                        <div class="explore_content_blog_info">
                           <h2><?php echo $location['title']; ?></h2>
                           <p><?php echo substr($location['description'], 0, 180) . "..." ?><a href="<?php echo "./individualPage.php?id=" . $location['id'] ?>" style="color:var(--blue); text-decoration:underline;">more</a></p>
                        </div>
                     </div>
            <?php
                  }
               }
            }
            ?>
         </div>
      </div>
   </div>

   <hr>


   <section style='padding:30px'>
      <div class="recommendation recommendation--medium">
         <h2>Places Near Me</h2>
         <ul class="recommendation__list" id='recommend'>

         </ul>
      </div>

   </section>
   <hr>

   <footer>
      <div class="footer__border__top">
      </div>

      <div class="footer__content">
         <div class="footer__list__feature">
            <h3>Top Cities</h3>
            <ul>
               <li><a href="./listOfPosts.php?search=pokhara">Pokhara</a></li>
               <li><a href="./listOfPosts.php?search=kathmandu">Kathmandu</a></li>
               <li><a href="./listOfPosts.php?search=biratnagar">Biratnagar</a></li>
               <li><a href="./listOfPosts.php?search=birjung">Birjung</a></li>
               <li><a href="./listOfPosts.php?search=nagarkot">Nagarkot</a></li>
            </ul>
         </div>
         <div class="footer__list__feature">
            <h3>Top Choices</h3>
            <ul>
               <li><a href="./listOfPosts.php?search=religious%20places">Religious Places</a></li>
               <li><a href="./listOfPosts.php?search=sightseeing">Sightseeing</a></li>
               <li><a href="./listOfPosts.php?search=trekking">Trekking</a></li>
               <li><a href="./listOfPosts.php?search=hiking">Hiking</a></li>
               <li><a href="./listOfPosts.php?search=leisure%20activities">Leisure activities</a></li>
               <li><a href="./listOfPosts.php?search=tours">Tours</a></li>
               <li><a href="./listOfPosts.php?search=road%20trips">Road trips</a></li>
            </ul>
         </div>
         <div class="footer__list__feature footer__list__feature--contact">
            <h3>Contact Us</h3>
            <ul>
               <li class="footer__list__feature--contact__header">Address</li>
               <ul>
                  <li>Baneshore,KTM</li>
               </ul>
               <li class="footer__list__feature--contact__header">Phone Number</li>
               <ul>
                  <li>+977 5555555</li>
                  <li>+977 5555555</li>
                  <li>+977 5555555</li>
               </ul>
               <li class="footer__list__feature--contact__header">Email</li>
               <ul>
                  <li>passionseekers@gmail.com</li>
               </ul>
            </ul>
         </div>
         <div class="footer__list__feature">
            <h3>Social Media</h3>
            <ul>
               <li><a href="https://www.twitter.com" target="_blank">Twitter</a></li>
               <li><a href="https://www.instagram.com" target="_blank">Instagram</a></li>
               <li><a href="https://www.youtube.com" target="_blank">Youtube</a></li>
               <li><a href="https://www.facebook.com" target="_blank">Facebook</a></li>
               <li><a href="https://www.pinterest.com" target="_blank">Pinterest</a></li>
            </ul>
         </div>
      </div>
      <div class="footer__website__legal__info">
         <h1>Passion Seekers</h1>
         <p>Privacy Policy</p>
         <p>Copyright &#169; 2021 All Rights Reserved </p>
      </div>
   </footer>
   <?php require_once './__adminJobs.php' ?>
   <script src="./scripts/src.js"></script>
   <script src="./scripts/individualPage.js"></script>
   <script src="scripts/jquery.min.js"></script>

<script>
      getLocation()

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  var long = position.coords.latitude ;
  var lat = position.coords.longitude;
  $.ajax({
        url: "__recc.php",
        type: "POST",
        data: {
            'long' : long,
            'lat' : lat,
            'recomend' : 'true'},
        success:function(response){
            $('#recommend').html(response);
        }
  });

}
</script>
</body>
</html>