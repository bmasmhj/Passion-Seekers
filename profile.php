<?php

use function PHPUnit\Framework\isNull;

session_start();
require_once './__assignSession.php';
require_once './__connection.php';
require_once './__loginAndSignupErrorMsg.php';

// 
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
   <link rel="stylesheet" href="./style/profile.css">
   <link rel="icon" href="./style/assests/travel.png">
   <title>Passion Seekers | Profile</title>
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
   //fetchhing users info
   $err = [] ;
   if ($_SESSION['admin'] == true) {
      $query = mysqlCheckAdminsUsername($_SESSION['username']);
   } else {
      $query = mysqlCheckUsersUsername($_SESSION['username']);
   }

   $statusAboutUser = $connection->query($query);
   $userInfoOnArray = $statusAboutUser->fetch_assoc();
   // print_r($userInfoOnArray);
   // echo $userInfoOnArray['avatar'] ? "exists" : 'not exists';


   if (isset($_POST['update_user'])) {

      if (isset($_POST['name'])) {
         $name = trim($_POST['name']);
      }

      if (isset($_POST['email']) && !empty($_POST['email'])) {
         $email = trim($_POST['email']);
      } else {
         $err['email'] = "Error on Email";
      }

      if (isset($_POST['phone'])) {
         $phone = trim($_POST['phone']);
      }

      if (isset($_POST['address'])) {
         $address = trim($_POST['address']);
      }

      if (isset($_POST['username']) && !empty($_POST['username'])) {
         $username = trim($_POST['username']);
      } else {
         $err['username'] = "Error on username";
      }

      if (!empty($_POST['password'])) {
         if (isset($_POST['password']) && strlen($_POST['password']) > 7 && isset($_POST['repassword']) && !empty($_POST['repassword']) && $_POST['repassword'] == $_POST['password']) {
            $password = md5($_POST['password']);
         } else {
            $err['password'] = "Error on password!";
         }
      } else {
         $password = NULL;
      }

      // echo "NAME" . $name . "<br>";
      // echo "EMAIL:" . $email . "<br>";
      // echo "PHONE" . $phone . "<br>";
      // echo "ADDRESS" . $address . "<br>";
      // echo "USERNAME" . $username . "<br>";
      // echo "PASSWORD" . $password . "<br>";
      // echo is_null($password)? "PASSWORD IS Null":"PASSWORD IS Not NUll<br>";
      // print_r($_SESSION);

      // check wheather username exists or not
      if (isset($username) && $username != $_SESSION['username']) {

         $queryUsers = mysqlCheckUsersUsername($username);
         $queryAdmin = mysqlCheckAdminsUsername($username);

         $resultUsers = $connection->query($queryUsers);
         $resultAdmin = $connection->query($queryAdmin);

         echo $resultUsers->num_rows;
         echo $resultAdmin->num_rows;

         if ($resultUsers->num_rows != 0 || $resultAdmin->num_rows != 0) {
            $err_username = true;
            $err['username'] = "Username is taken!";
         }
      }

      // check wheather email exists or not
      if (isset($email) && $email != $_SESSION['email']) {
         $queryUsers = mysqlCheckUsersEmail($email);
         $queryAdmin = mysqlCheckAdminsEmail($email);

         $resultUsers = $connection->query($queryUsers);
         $resultAdmin = $connection->query($queryAdmin);

         echo $resultUsers->num_rows;
         echo $resultAdmin->num_rows;

         if ($resultUsers->num_rows != 0 || $resultAdmin->num_rows != 0) {
            $err_email = true;
            $err['email'] = "Email is taken!";
         }
      }

      // upload avatar
      // echo "this is file";
      // default upload size of files in apache server is 2MB changing it to 10MB in php.in
      // print_r($_FILES);
      if ($_FILES['upload_avatar_image']['error'] == 0) {

         if ($_FILES['upload_avatar_image']['size'] <= 10485800) {
            $file_types = ['image/png', 'image/jpeg', 'image/gif'];

            if (in_array($_FILES['upload_avatar_image']['type'], $file_types)) {
               //move upload file
               $imageName = "imagePost" . uniqid() . rand() . uniqid() . rand() . ".png";
            } else {
               $err['photo'] = 'Select Valid format';
            }
         } else {
            $err['photo'] = 'Select photo upto 100 mb';
         }
      }

      if (count($err) > 0) {
         $err_update = true;
      } else {
         $err_update = false;
      }

      // print_r($err);

      if (!$err_update) {

         $updateProfileQuery = mysqlUpdateProfile($_SESSION['id'], $name, $username, $password, $email, $address, $phone, $imageName, $_SESSION['admin']);
         $result = $connection->query($updateProfileQuery);

         if (isset($imageName)) {

            //check if previous image exists or not if yes remove it from server
            if ($userInfoOnArray['avatar']) {
               if (!unlink("./images/avatar/" . $userInfoOnArray['avatar'])) {
                  $err['removingImageFromServer'] = "Error in removing files from the file Server.";
               }
            }

            //upload new images to server 
            if (move_uploaded_file($_FILES['upload_avatar_image']['tmp_name'], 'images/avatar/' . $imageName)) {
               echo 'Image uploaded';
            } else {
               $err['images'] = 'error on image uploaded';
            }
         }

         if (!$result) {
            $err['database'] = "Internal Server error";
         } else {
            echo "<script>alert('User profile is updated!')</script>";

            //update the session and cookie values if exists
            $queryToGetUserByID = mysqlGetUserById($_SESSION['id'], $_SESSION['admin']);
            $userInfo = ($connection->query($queryToGetUserByID))->fetch_assoc();

            print_r($userInfo);

            if ((isset($_COOKIE['username'])) && !empty($_COOKIE['username'])) {
               setcookie('username', $userInfo['username'], time() + (60 * 60 * 24 * 7));
               setcookie('name', $userInfo['name'], time() + (60 * 60 * 24 * 7));
               setcookie('email', $userInfo['email'], time() + (60 * 60 * 24 * 7));
            };

            session_start();
            $_SESSION['username'] = $userInfo['username'];
            $_SESSION['name'] = $userInfo['name'];
            $_SESSION['email'] = $userInfo['email'];

            header('location:./profile.php');
         }
      }

      // echo 'this is working';
   }
   ?>

   <header>
      <?php require_once './__navigationBar.php'; ?>
   </header>
   <?php

   // print_r($statusAboutUser);

   if ($statusAboutUser->num_rows == 1) {
      $user = $statusAboutUser->fetch_assoc();
      // print_r($user);
   ?>
      <section class="user__information">
         <div class="user__information__details">
            <h2 class="user__information__details__title">User Informations</h2>
            <hr style="margin: 0; border:black 1px solid;">
            <form method="POST" class="user__information__details_form" enctype="multipart/form-data">

               <div class="users__information__detail">
                  <div class="user__information__avatar">
                     <img src="./images/avatar/<?php echo isset($userInfoOnArray['avatar']) ? $userInfoOnArray['avatar'] : "default.png"; ?>" alt="profile picture">
                     <label for="upload_avatar_image" class="user__information__avatar__label">Change avatar</label>
                     <input type="file" class="user__information__avatar__upload__btn" value="Change avatar" id="upload_avatar_image" name="upload_avatar_image" style="display: none;">
                  </div>
               </div>

               <div class="users__information__detail">
                  <Label for="name">Name</Label>
                  <input type="text" id="name" name="name" class="users__information__detail__input" autocomplete="off" value="<?php echo $userInfoOnArray['name']; ?>">
               </div>

               <div class="users__information__detail">
                  <Label for="username">Username</Label>
                  <input type="text" id="username" name="username" class="users__information__detail__input" autocomplete="off" value="<?php echo $userInfoOnArray['username']; ?>">
               </div>

               <div class=" users__information__detail">
                  <Label for="email">Email</Label>
                  <input type="text" id="email" name="email" class="users__information__detail__input" autocomplete="off" value="<?php echo $userInfoOnArray['email']; ?>">
               </div>

               <div class="users__information__detail">
                  <Label for="phone_number">Phone Number</Label>
                  <input type="text" id="phone_number" autocomplete="off" value="<?php echo $userInfoOnArray['phone_number']; ?>" name="phone">
               </div>

               <div class="users__information__detail">
                  <Label for="address">Address</Label>
                  <input type="text" id="address" name="address" class="users__information__detail__input" autocomplete="off" value="<?php echo $userInfoOnArray['address']; ?>">
               </div>

               <div class="users__information__detail">
                  <Label for="password">Password</Label>
                  <input type="text" id="password" name="password" class="users__information__detail__input" name="password" autocomplete="off" placeholder="Enter password to change it">
               </div>

               <div class="users__information__detail">
                  <Label for="repassword">Re-enter Password</Label>
                  <input type="text" id="repassword" name="repassword" class="users__information__detail__input" autocomplete="off" placeholder="Enter password again if you want to change it">
               </div>

               <button type="submit" name="update_user" class="user__information__details__update__btn">Update</button>
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
   <script>
      const userDetails = document.querySelectorAll('.users__information__detail__input');

      userDetails.forEach((element) => {
         element.addEventListener('focus', (e) => {
            element.classList.add('input--focus')
         })

         element.addEventListener('blur', (e) => {
            element.classList.remove('input--focus')
         })

      })
   </script>
</body>

</html>