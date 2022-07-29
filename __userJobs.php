   <?php
   require_once './__connection.php';
   if (isset($_SESSION['is_user'])) {
   ?>
      <section class="user__interaction">
         <div class="user__interaction__actions">
            <?php
            if (isset($id) && !isset($err['post'])) {
               if (!isset($err['post'])) {
                  $queryToCheckFavorite = mysqlCheckInFavorite($_SESSION['id'], $id);
                  $isInFavorite = $connection->query($queryToCheckFavorite);
            ?>

                  <?php if ($isInFavorite->num_rows == 1) { ?>
                     <a href=<?php echo isset($id) ? "./removeFromFavorite.php?id=" . $id : "" ?>>
                        <button class="user__interaction__button">
                           <img class="user__interaction__image" src="./icon collections/remove black.png" alt="remove post logo">
                           <p>Saved. Remove from favorite? </p>
                        </button>
                     </a>
                  <?php } else { ?>
                     <a href=<?php echo isset($id) ? "./saveToFavorite.php?id=" . $id  : "" ?>>
                        <button class="user__interaction__button">
                           <img class="user__interaction__image" src="./icon collections/save.png" alt="save post logo">
                           <p>Save to favorite?<?php echo isset($id) ? " id=" . $id  : "" ?></p>
                        </button>
                     </a>
               <?php }
               }
               ?>
            <?php } ?>
            <a href="./favoriteList.php">
               <button class="user__interaction__button">
                  <img class="user__interaction__image" src="./icon collections/list black.png" alt="list post logo">
                  <p>Favorite List</p>
               </button>
            </a>
            <a href="./postReview.php">
               <button class="user__interaction__button">
                  <img class="user__interaction__image" src="./icon collections/review black.png" alt="review post logo">
                  <p>Give Review</p>
               </button>
            </a>
         </div>
      </section>
   <?php } ?>