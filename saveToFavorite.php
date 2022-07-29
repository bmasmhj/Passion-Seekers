<?php

session_start();
require_once './__connection.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
   $id = $_GET['id'];
   $userId = $_SESSION['id'];
   $queryToSaveInFavorite = mysqlSaveToFavorite($_SESSION['id'], $id);

   $output = $connection->query($queryToSaveInFavorite);
}

header("location:./individualPage.php?id=$id");
