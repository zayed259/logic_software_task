<?php
include 'connection.php';
// Delete Record from Database with Ajax jQuery
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM `users` WHERE `id` = '$id'";
    $result = $connection->query($sql);
    if ($result) {
        echo json_encode('Record Deleted Successfully');
    } else {
        echo json_encode('Record Not Deleted');
    }
}
