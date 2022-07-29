<?php
require_once './__connection.php';

if (!isset($err['post']) && !isset($err['id']) && isset($_GET['removeCommentId']) && !empty($_GET['removeCommentId']) && is_numeric($_GET['removeCommentId'])) {
    $queryToRemoveComment = mysqlRemoveComment($_GET['removeCommentId']);
    $id = $_GET['id'];
    $isCommentDeleted = $connection->query($queryToRemoveComment);
    if($isCommentDeleted){

    }
    header('Location: ./individualPage.php?id='.$id);
    exit;   

 }


 ?>