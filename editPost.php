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
   <title>Passion Seekers | Edit Post</title>
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

   if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
      $id = $_GET['id'];
   }

   //when user modify the content and tries to update it.
   if (isset($_POST['update'])) {

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

      if (isset($_POST['lattitude']) && is_numeric($_POST['lattitude'])) {
         $lattitude = $_POST['lattitude'];
      } else {
         $err['lattitude'] = 'Invalid lattitude!';
      }

      if (isset($_POST['longitude']) && is_numeric($_POST['longitude'])) {
         $longitude = $_POST['longitude'];
      } else {
         $err['longitude'] = 'Invalid longitude!';
      }

      if (isset($_POST['type-of-activity']) && $_POST['type-of-activity']) {
         $typeOfActivities = trim($_POST['type-of-activity']);
      } else {
         $err['type-of-activity'] = 'Invalid Type of Activity!';
      }

      $statusForPost = $_POST['status'];
      $postIsActive = $statusForPost == "active" ? 1 : 0;

      // echo $title . '<br>';
      // // echo $description;
      // echo $lattitude . '<br>';
      // echo $longitude . '<br>';
      // echo ($postIsActive == true ? "active" : "not-active") . '<br>';

      if (!isset($err['longitude']) && !isset($err['lattitude']) && !isset($err['title']) && !isset($err['description'])) {

         // saving images in server
         $imageNames = [];
         $countFiles = count($_FILES['images']['name']);

         // echo "<br>this is working 1<br>";
         //query to insert the information to database
         $queryToInsertData  = mysqlUpdatePost($id, $title, $description, $lattitude, $longitude, $typeOfActivities, $postIsActive);
         $result = $connection->query($queryToInsertData);

         // echo "<br>" . $queryToInsertData . "<br>";

         // echo "<br>".$queryToInsertData."<br>";
         // print_r($result);
         // echo "this is working 2";

         if ($countFiles > 0 && $_FILES['images']['error'][0] == 0) {
            // echo "<br> step 1 <br>";
            // echo $countFiles;

            for ($i = 0; $i < $countFiles; $i++) {
               $filename = $_FILES['images']['name'][$i];
               // Upload file
               // move_uploaded_file($_FILES['file']['tmp_name'][$i], 'upload/' . $filename);
               // echo $filename . "<br>";
               // echo $_FILES['images']['error'][$i];

               //check for error on the each upload

               if ($_FILES['images']['error'][$i] == 0) {
                  // echo "step 2 <br>";

                  if ($_FILES['images']['size'][$i] <= 10485800) {
                     // echo "step 3 <br>";

                     $file_types = ['image/png', 'image/jpeg', 'image/gif', 'image/jpg'];

                     if (in_array($_FILES['images']['type'][$i], $file_types)) {
                        echo "step 4 <br>";
                        //move upload file to server
                        $imageName = "imagePost" . uniqid() . rand() . uniqid() . rand() . ".png";
                        array_push($imageNames, $imageName);

                        if (move_uploaded_file($_FILES['images']['tmp_name'][$i], 'images/posts/' . $imageName)) {
                           echo '<script>console.log("Image uploaded")</script>';
                        } else {
                           $err['images'] = 'error on image uploaded';
                        }
                     } else {
                        $err['images'] = 'Select Valid format';
                     }
                  } else {
                     $err['images'] = 'Select images upto 10 mb' . $index;
                  }
               }
            }
         }

         if (count($err) == 0 && $_FILES['images']['error'][0] == 0 && $countFiles > 0) {

            //removing previously uploaded images from the database and the localsystem
            $queryToGetImagesNamesToDelete = mysqlGetPost($id, true)[1];

            $imageNamesArrayToDelete = $connection->query($queryToGetImagesNamesToDelete);
            $imageNamesToDelete = [];

            while ($row = $imageNamesArrayToDelete->fetch_assoc()) {
               array_push($imageNamesToDelete, $row);
            }

            foreach ($imageNamesToDelete as $image) {
               // removing files from filesystem of server
               if (!unlink("./images/posts/" . $image['image'])) {
                  $err['removingImageFromServer'] = "Error in removing files from the file Server.";
               }
            }

            $result = $connection->query(mysqlRemoveAllImagesByLocationId($id));

            //adding new updated imagedetails to the database
            foreach ($imageNames as $name) {
               $queryToInsertImage = mysqlAddImage($name, $id);
               $connection->query($queryToInsertImage);
            };

            header('location:./individualPage.php?id=' . $id);
         }

         if ($result == 1 && $postIsActive == 1) {
            header("location:./individualPage.php?id=$id");
         }
      }
   }

   //fetching the data from the database to the UI if user is valid
   $checkAdminQuery = mysqlisAdmin($_SESSION['id'], $_SESSION['username']);
   $checkAdminResult = $connection->query($checkAdminQuery);

   if ($checkAdminResult->num_rows == 1) {

      if (isset($id)) {
         $getQuery = mysqlGetPost($id, $admin = true);
         $result = $connection->query($getQuery[0]);

         if ($result->num_rows == 1) {
            $postInformations = $result->fetch_assoc();
            // print_r($postInformations);
         } else {
            $err['id'] = 'Post Not found with id=' . $id . ' !';
            unset($id);
         }
      }
   } else {
      $err['users'] = "Not a valid User!";
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
               <button class="search__by__post__item__search">Search</button>
            </div>
         </form>
      </div>


      <hr>

      <?php if (isset($id)) { ?>
         <section class="location__information">
            <h2 class="location__information__title">Edit Post</h2>

            <form method="post" class="location__information_upload_form" enctype="multipart/form-data">

               <div class="location_information_upload_form_item">
                  <Label for="title">Title</Label>
                  <input type="text" name="title" id="title" placeholder="Enter title here" value=<?php echo isset($postInformations) ? "\"" . $postInformations['title'] . "\"" : ''; ?>>
               </div>

               <div class="location_information_upload_form_item">
                  <Label for="description">Description</Label>
                  <textarea type="text" name="description" id="description" placeholder="Enter description here"><?php echo isset($postInformations) ? $postInformations['description'] : ''; ?></textarea>
               </div>

               <div class="location_information_upload_form_item">
                  <Label for="lattitude">Lattitude</Label>
                  <input type="number" name="lattitude" id="lattitude" placeholder="Enter lattitude here" value=<?php echo isset($postInformations) ? "\"" . $postInformations['lattitude'] . "\"" : ''; ?> step="any">
               </div>

               <div class="location_information_upload_form_item">
                  <Label for="longitude">Longitude</Label>
                  <input type="number" name="longitude" id="longitude" placeholder="Enter longitude here" value=<?php echo isset($postInformations) ? "\"" . $postInformations['longitude'] . "\"" : ''; ?> step="any">
               </div>

               <div class="location_information_upload_form_item">
                  <Label for="type-of-activity">Type of Activity</Label>
                  <input type="text" name="type-of-activity" id="type-of-activity" placeholder="Enter Type of Activity here" value=<?php echo isset($postInformations) ? "\"" . $postInformations['type_of_activity'] . "\"" : ''; ?>>
               </div>

               <div class="location_information_upload_form_item">
                  <Label for="images">Re-Upload Images</Label>
                  <input type="file" name="images[]" id="images" title="&nbsp;" multiple>
                  <p style="font-size: 0.6rem; color:#111; margin-left:25px;">* if new images are selected then previous images for this post will be removed
                  <p>
               </div>

               <div class="location_information_upload_form_item">
                  <Label for="status">Status</Label>

                  <input type="radio" name="status" id="status" class="location_information_upload_form_item_radio" <?php echo $postInformations['status'] == 1 ? "checked" : " " ?> value="active">

                  <p class="location_information_upload_form_item_text">Show</p>

                  <input type="radio" name="status" id="status" class="location_information_upload_form_item_radio" <?php echo $postInformations['status'] == 0 ? "checked" : " " ?> value="hidden">

                  <p class="location_information_upload_form_item_text">Hide</p>
               </div>

               <div class=" location_information_upload_form_item">
                  <button type="submit" name="update" class="location_information_upload_form_item__submit">Submit</button>
               </div>

            </form>
         </section>
      <?php } ?>
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