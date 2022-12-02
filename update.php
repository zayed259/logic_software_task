<?php
include 'connection.php';
// Update Record in Database with Ajax jQuery
if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['address']) && isset($_POST['gender']) && isset($_POST['dob'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $sql = "UPDATE `users` SET `name`='$name',`phone`='$phone',`email`='$email',`address`='$address',`gender`='$gender',`dob`='$dob' WHERE `id` = '$id'";
    $result = $connection->query($sql);
}
