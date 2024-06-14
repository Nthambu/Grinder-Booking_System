<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header('Refresh:0; login.php');
    die();
}

$conn = mysqli_connect('localhost', 'root', '', 'userdatabase');
if (!$conn) {
    die("Unable to connect: " . mysqli_connect_error());
}

// Fetch all bookings
$query = "SELECT * FROM bookingdata ORDER BY booked_at DESC";
$result = $conn->query($query);

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr data-id='{$row['id']}'>
                <td>{$row['id']}</td>
                <td>{$row['fullname']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['town']}</td>
                <td>{$row['area']}</td>
                <td>{$row['service']}</td>
                <td>{$row['day']}</td>
                <td>{$row['booked_at']}</td>
                <td class='status'>{$row['status']}</td>
            </tr>";
        }
    } else {
        echo 'No bookings found';
    }
} else {
    echo 'Query error: ' . $conn->error;
}

$conn->close();
?>
