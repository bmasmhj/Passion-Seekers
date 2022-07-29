<?php
session_start();
require_once './__assignSession.php';
require_once './__connection.php';
require_once './__loginAndSignupErrorMsg.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="./style/style.css">
   <link rel="stylesheet" href="./style/header-navigationBar.css">
   <link rel="stylesheet" href="./style/individual-page.css">
   <link rel="stylesheet" href="./style/recommendation.css">
   <link rel="stylesheet" href="./style/admin-jobs.css">
   <link rel="icon" href="./style/assests/travel.png">
   <title>Passion Seekers</title>
</head>

<body class="overflow__body">
   <script>
      function confrimlogout() {
         const confrimation = confirm('Are you sure you wanna logout?');
         if (confrimation) {
            location.href = './logout.php';
         }
      }
   </script>
   <?php
   if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
      $id = $_GET['id'];
      $query = mysqlGetPost($_GET['id']);
      $resultForlocationInfo = $connection->query($query[0]);

      if ($resultForlocationInfo->num_rows == 1) {
         $resultForlocationImages = $connection->query($query[1]);

         $images = [];
         while ($row = $resultForlocationImages->fetch_assoc()) {
            array_push($images, $row);
         }
         $resultForlocationInfo = $resultForlocationInfo->fetch_assoc();
      } else {
         $err['post'] = "Post doesn't exists" . ($_SESSION['admin'] == true ? " for id=$id. Post might be hidden" : " ") . " !";
      }
   } else {
      $err['id'] = "Invalid id value!";
   }

   ?>
   <header>
      <?php require_once './__navigationBar.php' ?>
   </header>
   <div class="post__content__container">
      <section>
         <?php if (count($err) == 0) { ?>
            <div class="post">
               <h2 class="post__title"><?php echo $resultForlocationInfo['title'] ?></h2>


               <div class="post__image__slider">
                  <?php
                  $imageCount = count($images); ?>
                  <div class="post__image__slider__container">
                     <?php foreach ($images as $index => $image) { ?>
                        <div class="post__image__slider__container__slides fade">
                           <div class="numbertext"><?php echo $index + 1 . "/" . $imageCount ?></div>
                           <img src=<?php echo "./images/posts/" . $image['image'] ?>>
                           <!-- <div class="text">Author one</div> -->
                        </div>
                     <?php } ?>

                     <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                     <a class="next" onclick="plusSlides(1)">&#10095;</a>

                  </div>
               </div>


               <h4 class="post__created__by"><?php echo $resultForlocationInfo['username'] ?></h4>
               <h4 class="post__created__at"><?php echo $resultForlocationInfo['created_at'] ?></h4>
               <p class="post__image__slider__typeOfActivity"><?php echo $resultForlocationInfo['type_of_activity'] ?></p>
               <a href="<?php echo "https://maps.google.com/?q=" . $resultForlocationInfo['lattitude'] . "," . $resultForlocationInfo['longitude'] . "&ll=" . $resultForlocationInfo['lattitude'] . "," . $resultForlocationInfo['longitude'] . "&12z"; ?>" class="post__image__slider__location__redirect" target="_blank">View Location on Google maps</a>
               <pre>
               <p class="post__image__slider__description"><?php echo $resultForlocationInfo['description'] ?></p>
               </pre>

               <?php if (!isset($err['post'])) { ?>
                  <hr class="separator__comment">
                  <div class="individual__post__comments__section">
                     <h4 class="post__comment__title">Comments</h4>
                     <div class="post__comment__view">

                        <?php
                        //check if user is logged in
                        $queryToCheckUser = mysqlCheckUsersUsername($_SESSION['username']);
                        $isValidUser = ($connection->query($queryToCheckUser))->num_rows == 1 ? true : false;
                        //check if user is admin
                        $checkAdminQuery = mysqlisAdmin($_SESSION['id'], $_SESSION['username']);
                        $result = $connection->query($checkAdminQuery);

                        if (isset($_POST['post_comment'])) {
                           if (!empty($_POST['comment'])) {
                              if ($isValidUser || $result->num_rows != 1) {

                                 $queryToInsertComment = mysqlInsertComment($_SESSION['id'], $id, $_POST['comment']);

                                 $output = $connection->query($queryToInsertComment);
                                 if ($output != 1) {
                                    $err['comment']  = "Failed to comment!";
                                 }
                              } else {
                                 $err['comment'] = 'Please login as Users to Comment.';
                              }
                           } else {
                              $err['comment'] = 'Enter valid comment.';
                           }
                        }

                        //removing comment
                        //removing the comment as user/admin
                 

                        //fetching comments
                        $pageOffset = 10;
                        $pageNumberForComment =  (isset($_GET['comment']) && is_numeric($_GET['comment'])) ? $_GET['comment'] : 1;

                        $queryToGetComments = mysqlgetComments($id, $pageNumberForComment - 1, $pageOffset);
                        $comments = [];
                        $getComments = $connection->query($queryToGetComments);

                        while ($row = $getComments->fetch_assoc()) {
                           array_push($comments, $row);
                        }

                        // echo "<pre>";
                        // print_r($comments);
                        // print_r($_SESSION);
                        // echo "</pre>";

                        if (count($comments) > 0) {
                           foreach ($comments as $comment) {
                        ?>
                              <div class="post__comment__comments">
                                 <div class="post__comment__avatar__image"><img src="./images/avatar/<?php echo $comment['avatar'] ? $comment['avatar'] : 'default.png'; ?>" alt="profile image"></div>

                                 <div class="post__comment__details">
                                    <h3 class="post__comment__By" style="display: inline;"><?php echo $comment['username']; ?></h3>
                                    <p class="post__comment__At"><?php echo $comment['created_at']; ?></p>
                                    <p class=" post__comment__comment"><?php echo $comment['comment']; ?></p>
                                 </div>
                                 <?php
                                 if(isset($_SESSION['username'])){
                                    $ussnmm = $_SESSION['username'];
                                 }else{
                                    $ussnmm ='';
                                 }
                                  if (isset($_SESSION['admin']) || $ussnmm == $comment['username']) { ?>
                                    <div class="post__comment__remove__comment">
                                       <a href="./__delete.php?<?php echo "id=" . $id . "&removeCommentId=" . $comment['id']; ?>">&#9747;</a>
                                    </div>
                                 <?php } ?>
                              </div>
                        <?php }
                        }

                        ?>
                     </div>
                     <div class=" post__comment__post">
                        <form method="POST">
                           <input type="text" name="comment" placeholder="Comment here" autocomplete="off">
                           <button type="submit" name="post_comment">Comment</button>
                        </form>
                     </div>
                  </div>
            </div>
         <?php } ?>
      <?php } ?>
      </section>

      <aside>
         <div class="aside__container">

            <?php
            $suggentionFallback = !isset($err['post']) ? $resultForlocationInfo['type_of_activity'] : "sightseeing";
            $queryForRecentPost = mysqlRecentPosts($id, 3);
            $resultForRecentPost = $connection->query($queryForRecentPost);
            $postForRecentPosts = [];

            while ($row = $resultForRecentPost->fetch_assoc()) {
               array_push($postForRecentPosts, $row);
            }
            ?>

            <?php foreach ($postForRecentPosts as $index => $post) { ?>
               <div class="aside__recomendation">
                  <a href="<?php echo "./individualPage.php?id=" . $post['id'] ?>">
                     <h3><?php echo $post['title'] ?></h3>
                     <div class="aside__recomendation__content">
                        <img src=<?php echo "./images/posts/" . $post['image']; ?> alt="#">
                        <p><?php echo substr($post['description'], 0, 100) . "...<u>more</u>" ?></p>
                     </div>
                  </a>
               </div>
            <?php } ?>

         </div>
      </aside>


   </div>

   <div class="recommendation recommendation--small">
      <h2>Recommendations</h2>
      <ul class="recommendation__list">
         <?php
         $countOfRecomendations = 3;
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

   <?php require_once './__adminJobs.php' ?>
   <div style=" bottom:2rem;
                  display:flex;
                  flex-direction:column;
                  position:fixed;
                  right:20px;
         ">
      <?php
      if (count($err) > 0) {
         foreach ($err as $index => $message) {
            displayError(true, $message, $index + 1);
         }
      }
      ?>
   </div>

   <div class="end__of__page <?php echo count($err) != 0 ? "end__of__page--fixed" : ''; ?>"></div>

   <?php if (isset($err['post'])) { ?>
      <style>
         .overflow__body {
            overflow: hidden;
         }
      </style>
   <?php } ?>
   <script src="./scripts/individualPage.js"></script>
   <script>
      var slideIndex = 1;
      showSlides(slideIndex);

      function plusSlides(n) {
         showSlides(slideIndex += n);
      }

      function currentSlide(n) {
         showSlides(slideIndex = n);
      }

      function showSlides(n) {
         var i;
         var slides = document.getElementsByClassName("post__image__slider__container__slides");

         if (n > slides.length) {
            slideIndex = 1
         }
         if (n < 1) {
            slideIndex = slides.length
         }
         for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
         }

         slides[slideIndex - 1].style.display = "block";
      }
   </script>
   <script>
      const postTitle = document.querySelector('.post__title');
      let stateOfTitle = false;
      let changingTitle = setInterval(() => {
         if (stateOfTitle) {
            document.title = "Passion Seekers";
         } else {
            document.title = postTitle.textContent;
         }
         stateOfTitle = !stateOfTitle;
      }, 1000);

      setTimeout(() => {
         clearInterval(changingTitle);
         document.title = "Passion Seekers | " + postTitle.textContent;
      }, 9000)
   </script>
</body>

</html>