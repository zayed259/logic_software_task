<?php
include 'connection.php';
// Show All Records with Ajax jQuery
if (isset($_GET['show'])) {
    $sql = "SELECT * FROM `users`";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        $output = '';
        $sl = 1;
        while ($row = $result->fetch_assoc()) {
            $gender = $row['gender'];
            if ($gender == 1) {
                $g = 'Male';
            } elseif ($gender == 2) {
                $g = 'Female';
            } elseif ($gender == 3) {
                $g = 'Other';
            } else {
                $g = '';
            }
            $output .= '
            <tr>
                <td>' . $sl++ . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['phone'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['address'] . '</td>
                <td>' . $g . '</td>
                <td>' . $row['dob'] . '</td>
                <td>
                    <button class="btn btn-danger btn-sm deleteBtn" id="' . $row['id'] . '">Delete</button>
                    <button class="btn btn-info btn-sm editBtn" id="' . $row['id'] . '">Edit</button>
                </td>
            </tr>
            ';
        }
        echo $output;
    } else {
        echo '<h3 class="text-center text-danger">No Record Found</h3>';
    }
}
