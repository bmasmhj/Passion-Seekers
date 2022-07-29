<?php
session_start();
require_once './__loginAndSignupErrorMsg.php';
require_once './__connection.php';
require_once './__assignSession.php';
if ((isset($_SESSION['username'])) && !empty($_SESSION['username'])) {
   header('location:./index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="./style/assests/travel.png">
   <link rel="stylesheet" href="./style/style.css">
   <link rel="stylesheet" href="./style/signupPage.css">
   <link rel="icon" href="./style/assests/travel.png">
   <title>Passion Seekers | Signup Admin</title>
</head>

<body>

   <?php
   $err_msgs = [];

   if (isset($_GET['admin']) && $_GET['admin'] == 'false') {
      header('location:./signupPage.php');
   }

   if (isset($_POST['signup'])) {

      if (isset($_POST['name'])) {
         $name = trim($_POST['name']);
      }

      if (isset($_POST['email']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
         $email = trim($_POST['email']);
      } else {
         $err_email = true;
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
         $err_username = true;
      }

      if (isset($_POST['password']) && !empty($_POST['password'])  && strlen($_POST['password']) > 7 && isset($_POST['repassword']) && !empty($_POST['repassword']) && $_POST['repassword'] == $_POST['password']) {
         $password = md5($_POST['password']);
      } else {
         $err_password = true;
      }

      //check wheather username exists or not
      if (isset($username) && !$err_username) {
         $queryUsers = mysqlCheckUsersUsername($username);
         $queryAdmin = mysqlCheckAdminsUsername($username);

         $resultUsers = $connection->query($queryUsers);
         $resultAdmin = $connection->query($queryAdmin);

         echo $resultUsers->num_rows;
         echo $resultAdmin->num_rows;

         if ($resultUsers->num_rows != 0 || $resultAdmin->num_rows != 0) {
            $err_username = true;
            echo $username . "Error";
            array_push($err_msgs, "Username is taken");
         }
      }

      //check wheather email exists or not
      if (isset($email) && !$err_email) {
         $queryUsers = mysqlCheckUsersEmail($email);
         $queryAdmin = mysqlCheckAdminsEmail($email);

         $resultUsers = $connection->query($queryUsers);
         $resultAdmin = $connection->query($queryAdmin);

         echo $resultUsers->num_rows;
         echo $resultAdmin->num_rows;

         if ($resultUsers->num_rows != 0 || $resultAdmin->num_rows != 0) {
            $err_username = true;
            array_push($err_msgs, "Email is taken.");
         }
      }

      if ($err_email || $err_password || $err_username) {
         $err_signup = true;
      } else {
         $err_signup = false;
      }

      //check if there is error if not then we procced to working with database
      if (!$err_signup) {
         if (isset($username) && isset($password) && isset($email)) {
            $query = mysqlSignUpAdmin($name, $username, $password, $email, $phone, $address);
            $result = $connection->query($query);
            echo !$result;
            if (!$result) {
               displayError(true, "Error on signing up.");
            } else {
               echo '<script>
                  alert("Request has been sent . Wait until it gets approved");
                  window.location.href= "./index.php";
               </script>';
               exit();
            }
         }
      }
   }
   ?>
   <div class="container">
      <div class="container__left">
         <div class="container__left__home__logo">
            <a href="./index.php">
               <img class="container__left__home__logo__img" src="./style/assests/logo home.png" alt="home-logo">
            </a>
         </div>
         <div class="container__left__logo__info">
            <a href="./index.php">
               <h3>Passion</h3>
               <h3>Seekers</h3>
            </a>
            <p>Making Dreams Comes True.</p>
         </div>
         <ul class="container__left__short__info">
            <li class="container__left__short__info__list">
               <div class="container__left__short__info__img">
                  <img src="./style/assests/search.png" alt="#">
               </div>
               <p>Search for locations</p>
            </li>
            <li class="container__left__short__info__list">
               <div class="container__left__short__info__img">
                  <img src="./style/assests/save.png" alt="#">
               </div>
               <p>Save your favorite location</p>
            </li>
            <li class="container__left__short__info__list">
               <div class="container__left__short__info__img">
                  <img src="./style/assests/location.png" alt="#">
               </div>
               <p>Find various Activities around you</p>
            </li>
         </ul>
      </div>
      <div class="container__right">
         <div class="container__right__form_signup">
            <h2>Signup for Admin</h2>
            <form action="#" method="POST" class="container__right__form_signup__form">

               <div class="container__right__form__element">
                  <Label for="name">Name</Label>
                  <input type="text" placeholder="Enter name here" id="name" name="name" <?php echo 'value="' . $name . '"' ?> autocomplete="off">
               </div>

               <div class="container__right__form__element">
                  <Label for="email">Email</Label>
                  <?php if (isset($err_email)) { ?>
                     <input type="text" placeholder="Enter email here" id="email" name="email" class="validation__input validation__input--empty" autocomplete="off">
                  <?php } else { ?>
                     <input type="text" placeholder="Enter email here" id="email" name="email" class="validation__input" <?php echo 'value="' . $email . '"' ?> autocomplete="off">
                  <?php  } ?>
                  <!-- <input type="text" placeholder="Enter email here" id="email" name="email"> -->
               </div>

               <div class="container__right__form__element">
                  <Label for="phone">Phone Number</Label>
                  <input type="text" placeholder="Enter phone here" id="phone" name="phone" <?php echo 'value="' . $phone . '"' ?> autocomplete="off">
               </div>

               <div class="container__right__form__element">
                  <Label for="address">Address</Label>
                  <input type="text" placeholder="Enter address here" id="address" name="address" <?php echo 'value="' . $address . '"' ?> autocomplete="off">
               </div>

               <div class="container__right__form__element">
                  <Label for="username">Username</Label>
                  <?php if (isset($err_username)) { ?>
                     <input type="text" placeholder="Enter username here" id="username" name="username" class="validation__input validation__input--empty" autocomplete="off">
                  <?php } else { ?>
                     <input type="text" placeholder="Enter username here" id="username" name="username" class="validation__input" <?php echo 'value="' . $username . '"' ?> autocomplete="off">
                  <?php } ?>
               </div>

               <div class="container__right__form__element">
                  <Label for="password">Password</Label>
                  <?php if (isset($err_password)) { ?>
                     <input type="password" placeholder="Enter password here" id="password" name="password" class="validation__input validation__input--empty" autocomplete="off">
                  <?php } else { ?>
                     <input type="password" placeholder="Enter password here" id="password" name="password" class="validation__input" autocomplete="off">
                  <?php } ?>
               </div>

               <div class="container__right__form__element">
                  <Label for="repassword">Re-enter password</Label>
                  <?php if (isset($err_re_password)) { ?>
                     <input type="password" placeholder="Enter Password here Again" id="repassword" name="repassword" class="validation__input validation__input--empty" autocomplete="off">
                  <?php } else { ?>
                     <input type="password" placeholder="Enter Password here Again" id="repassword" name="repassword" class="validation__input" autocomplete="off">
                  <?php } ?>
               </div>

               <div class="container__right__form__element container__right__form__element--signup__btn">
                  <input type="submit" value="Signup" name="signup">
               </div>

            </form>
            <hr>
         </div>

         <div style=" bottom:2rem;
                  display:flex;
                  flex-direction:column;
                  position:fixed;
                  right:20px;
         ">
            <?php
            if (count($err_msgs) > 0) {
               foreach ($err_msgs as $index => $message) {
                  displayError(true, $message, $index + 1);
               }
            } else {
               displayError($err_signup);
            }
            ?>
         </div>

      </div>
   </div>
   <script src="./scripts/validation.js"></script>
</body>

</html>