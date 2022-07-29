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
   <title>Passion Seekers | View Reviews</title>
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
   $query = mysqlGetReviewAll();
   $reviews = [];
   $output = $connection->query($query);

   while ($row = $output->fetch_assoc()) {
      array_push($reviews, $row);
   }
   $checkAdminQuery = mysqlisAdmin($_SESSION['id'], $_SESSION['username']);
   $result = $connection->query($checkAdminQuery);
   ?>

   <header>
      <?php require_once './__navigationBar.php'; ?>
   </header>

   <?php if ($result->num_rows == 1) { ?>

      <section class="review__list">
         <div class="review__list__container">
            <h2 class="review__list__title">Reviews List</h2>
            <table border="1" class="review__list__table">
               <thead class="review__list__head">
                  <th>S.N</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Submmited At</th>
               </thead>
               <tbody class="review__list__body">
                  <?php foreach ($reviews as $index => $review) { ?>
                     <tr>
                        <td><?php echo $index + 1 ?></td>
                        <td><?php echo $review['title'] ?></td>
                        <td><?php echo $review['description'] ?></td>
                        <td><?php echo $review['created_at'] ?></td>
                     </tr>
                  <?php } ?>
               </tbody>
            </table>
         </div>
      </section>
   <?php } else {
      $err['user'] = 'Not a valid User!';
   } ?>
   <div class="end__of__page end__of__page--absolute"></div>
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