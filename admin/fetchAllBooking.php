<?php
$conn = mysqli_connect('localhost', 'root', '', 'userdatabase');
if (!$conn) {
    die("Unable to connect: " . mysqli_connect_error());
}

$query = "SELECT * FROM bookingdata ORDER BY booked_at DESC";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

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
            <td>
                <a style='color:red;text-decoration:none;' onclick='return confirm(\"Are you sure you want to delete?\")' href='delete_booking.php?id={$row['id']}'>
                    Delete
                </a>
            </td>
          </tr>";
}

$conn->close();
?>
