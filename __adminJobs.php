   <?php require_once './__userJobs.php'; ?>
   <?php
   if (isset($_SESSION['admin'])) {
   ?>
      <section class="admin__interaction">
         <div class="admin__interaction__actions">

            <a href="./createPost.php">
               <button class="admin__interaction__button">
                  <img class="admin__interaction__image" src="./icon collections/create black.png" alt="create post logo">
                  <p>Created Post</p>
               </button>
            </a>

            <a href=<?php echo isset($id) ? "./editPost.php?id=" . $id : "./editPost.php" ?>>
               <button class="admin__interaction__button">
                  <img class="admin__interaction__image" src="./icon collections/edit black.png" alt="edit post logo">
                  <p>Edit Post<?php echo isset($id) ? " id=" . $id  : "" ?></p>
               </button>
            </a>

            <a href=<?php echo isset($id) ? "./removePost.php?id=" . $id . "&redirect=true" : "./removePost.php" ?>>
               <button class="admin__interaction__button">
                  <img class="admin__interaction__image" src="./icon collections/remove black.png" alt="remove post logo">
                  <p>Remove Post <?php echo isset($id) ? " id=" . $id  : "" ?></p>
               </button>
            </a>

            <a href="./allPosts.php">
               <button class="admin__interaction__button">
                  <img class="admin__interaction__image" src="./icon collections/list black.png" alt="list post logo">
                  <p>View Posts <br>(Tabular Form)</p>
               </button>
            </a>

            <a href="./adminRequests.php">
               <button class="admin__interaction__button">
                  <img class="admin__interaction__image" src="./icon collections/admin-list black.png" alt="list post logo">
                  <p>Admin request list</p>
               </button>
            </a>

            <a href="./viewReviews.php">
               <button class="admin__interaction__button">
                  <img class="admin__interaction__image" src="./icon collections/review black.png" alt="list post logo">
                  <p>View Reviews</p>
               </button>
            </a>
         </div>
      </section>
   <?php } ?>