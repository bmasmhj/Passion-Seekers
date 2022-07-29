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
   <link rel="stylesheet" href="./style/admin-jobs.css">
   <link rel="stylesheet" href="./style/review.css">
   <link rel="icon" href="./style/assests/travel.png">
   <title>Passion Seekers || Give Review</title>
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
   $queryToCheckUser = mysqlCheckUsersUsername($_SESSION['username']);
   $isValidUser = ($connection->query($queryToCheckUser))->num_rows == 1 ? true : false;
   $isValidUser = $isValidUser && $_SESSION['is_user'] == true;

   if ($isValidUser) {
      if (isset($_POST['submit_review'])) {

         if (isset($_POST['title']) && !empty($_POST['title'])) {
            $title = trim($_POST['title']);
         } else {
            $err['title'] = "Invalid title!";
         }

         if (isset($_POST['description']) && !empty($_POST['description'])) {
            $description = trim($_POST['description']);
         } else {
            $err['description'] = "Invalid description!";
         }

         if (!(count($err) > 0) && $isValidUser == true) {
            $queryToInsertReview = mysqlPostReview($title, $description, $_SESSION['id']);
            $output = $connection->query($queryToInsertReview);

            echo $queryToInsertReview . ";";
            echo $output . "this is output";
            if ($output) {
               echo "<script>alert('Review has been posted')</script>";
            } else {
               $err['post_review'] = "Error on posting review";
            }
         }
      }
   } else {
      $err['user'] = 'Please login as user';
   }
   ?>

   <header>
      <?php require_once './__navigationBar.php'; ?>
   </header>

   <?php if ($isValidUser) { ?>

      <section class="review__section">
         <div class="review__section__container">
            <h2 class="review__section__container" style="margin:10px;font-size:2rem;">Review</h2>
            <hr style="margin: 8px;">
            <form method="post" class="review_section__form">
               <div class="review__form__group">
                  <Label for="title">Title</Label>
                  <input type="text" placeholder="Enter title here." id="title" name="title" autocomplete="off">
               </div>
               <div class="review__form__group">
                  <Label for="description">Description</Label>
                  <textarea name="description" id="description" cols="30" rows="10" placeholder="Enter description here" name="description" autocomplete="off"></textarea>
               </div>
               <button name="submit_review" type="submit" class="review__section__submit">Submit</button>
            </form>
         </div>
      </section>

   <?php } ?>
   <?php require_once './__adminJobs.php' ?>
   <div style=" bottom:2rem;
                  display:flex;
                  flex-direction:column;
                  position:fixed;
                  right:20px;
                  text-align:center;
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