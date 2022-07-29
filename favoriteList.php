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
   <link rel="icon" href="./style/assests/travel.png">
   <link rel="stylesheet" href="./style/favorite-list.css">
   <title>Passion Seekers | Favorite Lists</title>
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
   $pageOffset = 10;
   $pageNumber = 1;

   if (isset($_GET['pageno']) && is_numeric($_GET['pageno'])) {
      $pageNumber = $_GET['pageno'];
   }

   if (isset($_SESSION['id']) && !empty($_SESSION['id']) && $_SESSION['is_user'] == true) {
      $queryToGetAllFavorite = mysqlGetAllFavoritePosts($_SESSION['id'], $pageNumber - 1, 10);
      $result = $connection->query($queryToGetAllFavorite);
      $posts = [];

      while ($row = $result->fetch_assoc()) {
         array_push($posts, $row);
      }
      // print_r($_SESSION);
   } else {
      $err['user'] = 'Please Login as a user!';
   }
   ?>


   <header>
      <?php require_once './__navigationBar.php'; ?>
   </header>

   <?php if(!$err['user']){?>
   <section class="favorite__list">
      <div class="favorite__list__container">
         <h2 class="favorite__list__title">Favorite Lists</h2>
         <table border="1" class="favorite__list__table">
            <thead class="favorite__list__table__head">
               <th>S.N</th>
               <th>Title</th>
               <th>Description</th>
               <th>Type of Activity</th>
               <th>Lattitude</th>
               <th>Longitude</th>
               <th>Saved at</th>
               <th>Location Id</th>
               <th>Actions</th>
            </thead>
            <tbody class="favorite__list__table__body">
               <?php foreach ($posts as $index => $post) { ?>
                  <tr>
                     <td><?php echo $index + 1 ?></td>
                     <td class="favorite__list__table__body__text"><?php echo $post['title'] ?></td>
                     <td class="favorite__list__table__body__text"><?php echo substr($post['description'], 0, 40) . ".... <a href='./individualPage.php?id=" . $post['id'] . "' class='favorite_list__description__more' >view more</a>" ?></td>
                     <td class="favorite__list__table__body__text"><?php echo $post['type_of_activity'] ?></td>
                     <td><?php echo substr($post['lattitude'], 0, 5) . "..." ?></td>
                     <td><?php echo substr($post['longitude'], 0, 5) . "..." ?></td>
                     <td><?php echo $post['created_at'] ?></td>
                     <td><?php echo $post['id'] ?></td>
                     <td><a <?php echo 'href="./removeFromFavorite.php?id=' . $post['id'] . '&redirect=favorite"' ?> class="favorite_list__description__delete">Delete</a></td>
                  </tr>
               <?php } ?>
            </tbody>
         </table>
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
</body>

</html>