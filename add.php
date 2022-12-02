<?php
include 'connection.php';
// Add Record in Database with Ajax jQuery
if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['address']) && isset($_POST['gender']) && isset($_POST['dob'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $sql = "INSERT INTO `users`(`name`, `phone`, `email`, `address`, `gender`, `dob`) VALUES ('$name','$phone','$email','$address','$gender','$dob')";
    $result = $connection->query($sql);
}
