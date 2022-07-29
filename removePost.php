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
   <link rel="stylesheet" href="./style/edit-post.css">
   <link rel="stylesheet" href="./style/admin-jobs.css">
   <link rel="icon" href="./style/assests/travel.png">
   <title>Passion Seekers | Remove Post</title>
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

   //fetching the data from the database to the UI if user is valid
   $checkAdminQuery = mysqlisAdmin($_SESSION['id'], $_SESSION['username']);
   $checkAdminResult = $connection->query($checkAdminQuery);

   if ($checkAdminResult->num_rows == 1) {
      if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
         $id = $_GET['id'];

         if (!isset($_GET['redirect']) && empty($_GET['redirect']) && $_GET['redirect'] != true) {
            if (isset($_GET['confrimation']) && !empty($_GET['confrimation']) && $_GET['confrimation'] == true) {
               $checkIfPostExistsQuery = mysqlGetPost($id, $admin = true);
               $result = ($connection->query($checkIfPostExistsQuery[0]))->num_rows == 1 ? true : false;
               if ($result) {

                  $deleteQuery = mysqlRemovePostAndImages($id);

                  //removing files from server
                  $imageNameToRemoveFromServer = [];
                  $imagesFromDb = $connection->query($checkIfPostExistsQuery[1]);
                  while ($row = $imagesFromDb->fetch_assoc()) {
                     array_push($imageNameToRemoveFromServer, $row['image']);
                  }

                  foreach ($imageNameToRemoveFromServer as $image) {
                     if (!unlink("./images/posts/" . $image)) {
                        $err['removingImageFromServer'] = "Error in removing files from the file Server.";
                     }
                  }

                  $result[1] = $connection->query($deleteQuery[1]);
                  $result[0] = $connection->query($deleteQuery[0]);
   ?>
                  <script>
                     alert('Post <?php $id ?> has been deleted.!');
                  </script>
   <?php

               } else {
                  $err['post'] = "Post doesn't exist!";
               }
            }
         }
      }
   } else {
      $err['users'] = "Not a valid User!";
   }

   ?>

   <?php
   if (isset($_GET['remove'])) {
   ?>
      <script>
         const confrimation = confirm('Are you sure you wanna Delete?');
         if (confrimation) {
            location.href = <?php echo "'./removePost.php?id=$id&confrimation=true'"; ?>;
         }
      </script>
   <?php
   }
   ?>

   <header>
      <?php require_once './__navigationBar.php'; ?>
   </header>

   <hr>

   <?php if ($checkAdminResult->num_rows == 1) {  ?>
      <div class="search__by__post">
         <h2 class="search__by__post__title">Post Id</h2>
         <form method="GET">
            <div class="search__by__post__item">
               <input type="number" name="id" class="search__by__post__item__input" placeholder="Enter post id here!" value=<?php echo isset($id) ? $id : ""; ?>>

               <button class="search__by__post__item__search" name="remove">Remove</button>
            </div>
         </form>
      </div>

      <hr>

   <?php } ?>


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