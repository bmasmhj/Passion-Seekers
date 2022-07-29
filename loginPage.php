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
   <link rel="stylesheet" href="./style/loginPage.css">
   <link rel="icon" href="./style/assests/travel.png">
   <title>Tourist Guide | Login</title>
</head>

<body>

   <?php

   if (isset($_GET['admin']) && $_GET['admin'] == true) {
      header('location:./loginPageAdmin.php');
   }

   $err_username = false;
   $err_password = false;
   $remember_me = false;
   $err_login = false;

   if (isset($_POST['login'])) {

      $err = [];

      if (isset($_POST['username']) && !empty($_POST['username'])) {
         $username = trim($_POST['username']);
      } else {
         $err_username = true;
      };

      if (isset($_POST['password']) && !empty($_POST['password'])) {
         $password = md5($_POST['password']);
      } else {
         $err_password = true;
      };

      if (isset($username) && isset($password)) {
         $sql = mysqlLoginQuery($username, $password);
         $result = $connection->query($sql);
         $login = $result->num_rows == 1 ? true : false;

         if ($login) {
            $data = $result->fetch_assoc();

            if (isset($_POST['remember__me'])) {
               setcookie('username', $username, time() + (60 * 60 * 24 * 7));
               setcookie('name', $data['name'], time() + (60 * 60 * 24 * 7));
               setcookie('email', $data['email'], time() + (60 * 60 * 24 * 7));
               setcookie('id', $data['id'], time() + (60 * 60 * 24 * 7));
               setcookie('is_user', $data['id'], time() + (60 * 60 * 24 * 7));
            };

            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $data['name'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['id'] = $data['id'];
            $_SESSION['is_user'] = true;

            header("location:index.php");
            exit();
         } else {
            $loginFailed = true;
            $loginFailedUsers = true;
            $loginFailedPassword = true;
         }
      }

      if ($err_password || $err_username) {
         $err_login = true;
      } elseif ($loginFailed = true || $loginFailedUsers = true || $loginFailedPassword = true) {
         $loginAuthenticationFalied = true;
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
         <div class="container__right__form_login">
            <h2>Login</h2>
            <form action="#" class="container__right__form_login__form" method="POST">

               <div class="container__right__form__element">
                  <Label for="username">Username</Label>

                  <?php if (isset($err_username)) { ?>
                     <input type="text" placeholder="Enter Username here" id="username" name="username" class="validation__input validation__input--empty">
                  <?php } else { ?>
                     <input type="text" placeholder="Enter Username here" id="username" name="username" class="validation__input" <?php echo 'value="' . $username . '"' ?>>
                  <?php } ?>

               </div>

               <div class="container__right__form__element">
                  <Label for="password">Password</Label>
                  <?php if (isset($err_password)) { ?>

                     <input type="password" placeholder="Enter password here" id="password" name="password" class="validation__input validation__input--empty">
                  <?php } else { ?>
                     <input type="password" placeholder="Enter password here" id="password" name="password" class="validation__input">
                  <?php } ?>
               </div>
               <div class="container__right__form__element container__right__form__element--checkbox">
                  <Label for="remember">Remember Me</Label>
                  <input type="checkbox" id="remember" name="remember__me">

                  <?php
                  echo $remember_me;
                  ?>

               </div>

               <div class="container__right__form__element container__right__form__element--login__btn">
                  <input type="submit" value="Login" name="login">
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
            if ($err_login) {
               displayError($err_login);
            } elseif (isset($loginAuthenticationFalied)) {
               displayError(true, "Invalid Username or Password !");
            }
            ?>
         </div>

      </div>
   </div>

   <script src="./scripts/validation.js"></script>
</body>

</html>