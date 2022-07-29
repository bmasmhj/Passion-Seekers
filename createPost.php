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
   <link rel="stylesheet" href="./style/createPost.css">
   <link rel="stylesheet" href="./style/admin-jobs.css">
   <link rel="icon" href="./style/assests/travel.png">
   <title>Passion Seekers | Create Post</title>
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

   //check if he is admin or not
   $checkAdminQuery = mysqlisAdmin($_SESSION['id'], $_SESSION['username']);
   $result = $connection->query($checkAdminQuery);

   if ($result->num_rows == 1) {
      if (isset($_POST['upload'])) {

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
            $lattitude = trim($_POST['lattitude']);
         } else {
            $err['lattitude'] = 'Invalid lattitude!';
         }

         if (isset($_POST['longitude']) && is_numeric($_POST['longitude'])) {
            $longitude = trim($_POST['longitude']);
         } else {
            $err['longitude'] = 'Invalid longitude!';
         }

         if (isset($_POST['type-of-activity']) && $_POST['type-of-activity']) {
            $typeOfActivities = trim($_POST['type-of-activity']);
         } else {
            $err['type-of-activity'] = 'Invalid Type of Activity!';
         }

         if (!isset($err['longitude']) && !isset($err['lattitude']) && !isset($err['title']) && !isset($err['description'])) {

            // saving images in server
            $imageNames = [];
            $countFiles = count($_FILES['images']['name']);

            if ($countFiles > 0 && $_FILES['images']['error'][0] == 0) {
               echo "<br> step 1 <br>";
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
                           // echo "step 4 <br>";

                           //move upload file to server
                           $imageName = "imagePost" . uniqid() . rand() . uniqid() . rand() . ".png";
                           array_push($imageNames, $imageName);

                           if (move_uploaded_file($_FILES['images']['tmp_name'][$i], 'images/posts/' . $imageName)) {
                              echo 'Image uploaded';
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
            } else {
               $err['images'] = 'Please upload at least one Image.';
            }

            if (count($err) == 0) {
               // echo "step 5";
               $queryToInsertData  = mysqlCreatePost($title, $description, $_SESSION['id'], $lattitude, $longitude, $typeOfActivities);

               // echo "<pre>" . $queryToInsertData . "</pre>";
               $output = $connection->query($queryToInsertData);

               echo "<br>" . $queryToInsertData . "this is output";
               $lastInsertedLocationId = mysqli_insert_id($connection);

               foreach ($imageNames as $name) {
                  $queryToInsertImage = mysqlAddImage($name, $lastInsertedLocationId);
                  $connection->query($queryToInsertImage);
               };
               header('location:./individualPage.php?id=' . $lastInsertedLocationId);
            }
         }
      }
   } else {
      $err['users'] = 'Not a valid User!';
   }

   ?>

   <header>
      <?php require_once './__navigationBar.php'; ?>
   </header>
   <hr>

   <?php if ($result->num_rows == 1) { ?>
      <section class="location__information">
         <h2 class="location__information__title">Create Post</h2>

         <form method="post" class="location__information_upload_form" enctype="multipart/form-data">

            <div class="location_information_upload_form_item">
               <Label for="title">Title</Label>
               <input type="text" name="title" id="title" placeholder="Enter title here" <?php echo isset($title) ? "value='" . $title . "'" : ""; ?>>
            </div>

            <div class="location_information_upload_form_item">
               <Label for="description">Description</Label>
               <textarea type="text" name="description" id="description" placeholder="Enter description here"><?php echo isset($description) ? $description : ""; ?></textarea>
            </div>
            <div class="location_information_upload_form_item">
               <Label for="type-of-activity">Type of Activity</Label>
               <input type="text" name="type-of-activity" id="type-of-activity" placeholder="Enter type of activity here" <?php echo isset($typeOfActivities) ? "value='" . $typeOfActivities . "'" : ""; ?>>
            </div>

            <div class="location_information_upload_form_item">
               <Label for="lattitude">Lattitude</Label>
               <input type="number" name="lattitude" id="lattitude" placeholder="Enter lattitude here" step="any" <?php echo isset($lattitude) ? "value='" . $lattitude . "'" : ""; ?>>
            </div>

            <div class="location_information_upload_form_item">
               <Label for="longitude">Longitude</Label>
               <input type="number" name="longitude" id="longitude" placeholder="Enter longitude here" step="any" <?php echo isset($longitude) ? "value='" . $longitude . "'" : ""; ?>>
            </div>

            <div class="location_information_upload_form_item">
               <Label for="images">Upload Images</Label>
               <input type="file" name="images[]" id="images" title="&nbsp;" multiple>
            </div>

            <div class="location_information_upload_form_item">
               <button type="submit" name="upload" class="location_information_upload_form_item__submit">Submit</button>
            </div>

         </form>
      </section>
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