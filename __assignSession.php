
<?php
if ((isset($_COOKIE['username'])) && !empty($_COOKIE['username'])) {

   $_SESSION['username'] = $_COOKIE['username'];
   $_SESSION['name'] = $_COOKIE['name'];
   $_SESSION['id'] = $_COOKIE['id'];
   $_SESSION['admin'] = $_COOKIE['admin'];
   $_SESSION['is_user'] = $_COOKIE['is_user'];
}

?>
