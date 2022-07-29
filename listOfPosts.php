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
   <link rel="stylesheet" href="./style/recommendation.css">
   <link rel="stylesheet" href="./style/footer.css">
   <link rel="stylesheet" href="./style/admin-jobs.css">
   <link rel="stylesheet" href="./style/list-of-posts.css">
   <link rel="icon" href="./style/assests/travel.png">
   <title>List of Posts</title>
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
   <?php
   $postsInformations = [];
   if (isset($_GET['search']) && !empty($_GET['search'])) {
      $pageOfset = 12;
      $pageNumber = 1;

      if (isset($_GET['pageno']) && is_numeric($_GET['pageno']) && $_GET['pageno'] > 1) {
         $pageNumber = $_GET['pageno'];
      }


      $queryTosearch = mysqlSearchPost($_GET['search'], $pageNumber - 1, $pageOfset);
      $result = $connection->query($queryTosearch);

      //for page number
      $totalNumberofPost = ($connection->query(mysqlSearchPostCount($_GET['search']))->fetch_assoc())['count'];
      $pageCount = ceil($totalNumberofPost / $pageOfset);

      if( $result -> num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         array_push($postsInformations, $row);
      }
   }
      // print_r($result);
      // print_r($postsInformations[0]);
      // echo $queryTosearch;
      // echo $totalNumberofPost . "<br>";
      // echo $pageCount . "<br>";
      // echo $pageNumber;
   }

   if (isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] == 'explore' && (!isset($_GET['search']) || !empty($_GET['search']))) {
      $queryToGetExplore = mysqlGetPostsForExploreAndActivities('explore');
      $exploreDatafromDatabase = $connection->query($queryToGetExplore);

      if(  $exploreDatafromDatabase -> num_rows > 0 ){

      while ($row = $exploreDatafromDatabase->fetch_assoc()) {
         array_push($postsInformations, $row);
      }
   }


   }

   if (isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] == 'activities' && (!isset($_GET['search']) || !empty($_GET['search']))) {
      $queryToGetActivity = mysqlGetPostsForExploreAndActivities('');
      // echo $queryToGetActivity;
      $activityDatafromDatabase = $connection->query($queryToGetActivity);

      if(  $activityDatafromDatabase -> num_rows > 0 ){

      while ($row = $activityDatafromDatabase->fetch_assoc()) {
         array_push($postsInformations, $row);
      }
   }
   }
   ?>
   <header>
      <?php require_once './__navigationBar.php' ?>
   </header>
   <section>

      <div class="recommendation recommendation--lists">

         <?php if (isset($_GET['search']) && !empty($_GET['search'])) { ?>
            <h2>Search results for "<?php echo $_GET["search"]; ?>"</h2>
         <?php } ?>

         <?php if (isset($_GET['type']) && !empty($_GET['type'])) { ?>
            <h2>Suggestion for places to <?php echo $_GET["type"]; ?> </h2>
         <?php } ?>

         <?php if (count($postsInformations) > 0) { ?>

            <ul class="recommendation__list recommendation__list--search__posts">

               <?php foreach ($postsInformations as $index => $post) { ?>
                  <li class="recommendation__list__item">
                     <a href="<?php echo "./individualPage.php?id=" . $post['id']; ?>">
                        <div class="recommendation__list__item_images">
                           <img src="<?php echo './images/posts/' . $post['image'] ?>" alt="#">
                        </div>
                     </a>
                     <div class="recommendation__list__item_info">
                        <h4><?php echo $post['title']; ?></h4>
                        <p><?php echo substr($post['description'], 0, 150) ?>...<a href="<?php echo "./individualPage.php?id=" . $post['id']; ?>" class="recommendation__list__item_more">more</a></p>
                     </div>
                  </li>
               <?php } ?>
            </ul>
         <?php } else { ?>
            <h2 style="color: #b01107;">" No Results Found "</h2>
         <?php } ?>

      </div>


   </section>
   <hr>
   <section>
      <div class="recommendation">
         <h2>Users also searched for</h2>
         <ul class="recommendation__list">
            <?php require_once './__recommendations.php'; ?>

            <?php foreach ($recomendationOfPosts as $recPost) { ?>
               <li class="recommendation__list__item">
                  <a href="<?php echo "./individualPage.php?id=" . $recpost['id']; ?>">
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

   </section>
   <!-- <div class="end__of__page"></div> -->
   <footer>
      <div class="footer__website__legal__info">
         <h1>Passion Seekers</h1>
         <p>Privacy Policy</p>
         <p>Copyright &#169; 2021 All Rights Reserved </p>
      </div>
   </footer>
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
   <script src="./scripts/individualPage.js"></script>
</body>

</html>