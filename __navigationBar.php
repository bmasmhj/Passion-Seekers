<?php
if (isset($_POST['search'])) {
   if (isset($_POST['search_input']) && !empty($_POST['search_input'])) {
      header("location:./listOfPosts.php?search=" . $_POST['search_input']);
   } else {
      header('location:./index.php');
   }
}

$err = [];
?>

<nav>
   <h1 class="website__name">
      <a href="./index.php">Passion Seekers</a><?php if(isset($_SESSION['admin'])){'<span class="website__user__type">admin</span>'; } ?>
   </h1>
   <ul>
      <li>
         <div class="search__posts">
            <form method="POST">
               <button type="button" class="search__form__btn" name="search">
                  <img src="./style/assests/search.png" alt="search">
               </button>
               <input type="text" class="search__form__field" name="search_input">
            </form>
         </div>
      </li>
      <li><a href="./listOfPosts.php?type=explore">Explore</a></li>
      <li><a href="./listOfPosts.php?type=activities">Activities</a></li>
      <!-- <li><a href="#">Trending places</a></li> -->
      <?php

      if (isset($_SESSION['username'])) {
         echo "<li><a href='./profile.php'>" . $_SESSION['username'] . "</a></li>";

         echo "<li class='logout__btn'>
                  <button 
                     href='./logout.php' 
                     class='logout__img'
                     onclick=\"confrimlogout()\"
                  ><img src='./style/assests/logout.png' width='18px' height='18px'>
                  </button>
                  <p>Logout<p>
               </li>";
      } else {
         echo "<li><a href='./signupPage.php'>Sign up</a></li>";
         echo "<li>|</li>";
         echo "<li><a href='./loginPage.php'>Login</a></li>";
      }

      ?>
   </ul>
</nav>