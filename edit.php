<?php
include 'connection.php';
// Edit Record in Database with Ajax jQuery
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $sql = "SELECT * FROM `users` WHERE `id` = '$id'";
    $result = $connection->query($sql);
    echo json_encode($result->fetch_assoc());
}
