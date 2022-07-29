<?php

session_start();
require_once './__connection.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
   $id = $_GET['id'];
   $userId = $_SESSION['id'];
   $queryToRemoveFromFavorite = mysqlRemoveFromFavorite($_SESSION['id'], $id);

   $output = $connection->query($queryToRemoveFromFavorite);
}

if (isset($_GET['redirect']) && !empty($_GET['redirect']) && $_GET['redirect'] == 'favorite') {
   echo "redirect";
   header("location:./favoriteList.php");
} else {
   header("location:./individualPage.php?id=$id");
}
