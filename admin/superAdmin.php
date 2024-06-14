<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header('Refresh:0; admin_login.php');
    die();
}

// Create a connection to the db
$conn = mysqli_connect('localhost', 'root', '', 'userdatabase');
if (!$conn) {
    die("Unable to connect: " . mysqli_connect_error());
}

// Fetch recent bookings in the last week
$query = "SELECT * FROM bookingdata WHERE booked_at >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) ORDER BY booked_at DESC";
$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Fetch total count of bookings from bookingdata
$countQuery = "SELECT COUNT(*) as total FROM bookingdata";
$countResult = $conn->query($countQuery);
if (!$countResult) {
    die("Count query failed: " . $conn->error);
}
$countRow = $countResult->fetch_assoc();
$totalBookings = $countRow['total'];

// Fetch total number of messages stored in contacts table
$countQuery1 = "SELECT COUNT(*) as total FROM contacts";
$countResult1 = $conn->query($countQuery1);
if (!$countResult1) {
    die("Count query 1 failed: " . $conn->error);
}
$countRow1 = $countResult1->fetch_assoc();
$totalMessages = $countRow1['total'];

// Fetch total number of testimonies stored in testimonies table
$countQuery2 = "SELECT COUNT(*) as total FROM testimonies";
$countResult2 = $conn->query($countQuery2);
if (!$countResult2) {
    die("Count query 2 failed: " . $conn->error);
}
$countRow2 = $countResult2->fetch_assoc();
$totalTestimonies = $countRow2['total'];

// Fetch total number of unattended bookings
$unattendedQuery = "SELECT COUNT(*) as total FROM bookingdata WHERE status = 'unattended'";
$unattendedResult = $conn->query($unattendedQuery);
if (!$unattendedResult) {
    die("Count query for unattended bookings failed: " . $conn->error);
}
$unattendedRow = $unattendedResult->fetch_assoc();
$totalUnattendedBookings = $unattendedRow['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SuperAdmin panel</title>
    <link rel="stylesheet" href="css/mystyles.css" />
</head>
<body>
<div class="ses">
    <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
    <div class="container">
        <div class="navigation">
            <ul>
                <li><a href=""><span class="icon"><ion-icon name="home-outline"></ion-icon></span><span class="title">Dashboard</span></a></li>
                <li><a href="Atestimonies.php"><span class="icon"><ion-icon name="people-outline"></ion-icon></span><span class="title">Testimonies</span></a></li>
                <li><a href="Amessages.php"><span class="icon"><ion-icon name="chatbubble-ellipses-outline"></ion-icon></span><span class="title">Messages</span></a></li>
                <li><a href="addAdmin.html"><span class="icon"><ion-icon name="help-outline"></ion-icon></span><span class="title">Add Admin</span></a></li>
                <li><a href="adminList.php"><span class="icon"><ion-icon name="settings-outline"></ion-icon></span><span class="title">Remove Admin</span></a></li>
                <li><a href="updateS_Password.php"><span class="icon"><ion-icon name="lock-open-outline"></ion-icon></span><span class="title">Change password</span></a></li>
                <li><a href="admin_Logout.php"><span class="icon"><ion-icon name="log-out-outline"></ion-icon></span><span class="title">Sign Out</span></a></li>
            </ul>
        </div>

        <div class="main">
            <div class="topbar">
                <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>
                <div class="search">
                    <label>
                        <input type="text" placeholder="search here" />
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
                <div class="user"></div>
            </div>

            <div class="cardbox">
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $totalBookings; ?></div>
                        <div class="cardName">Total customers</div>
                    </div>
                    <div class="iconBox"><ion-icon name="eye-outline"></ion-icon></div>
                </div>
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $totalUnattendedBookings; ?></div>
                        <div class="cardName">Unattended Bookings</div>
                    </div>
                    <div class="iconBox"><ion-icon name="cart-outline"></ion-icon></div>
                </div>
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $totalMessages; ?></div>
                        <div class="cardName">Messages</div>
                    </div>
                    <div class="iconBox"><ion-icon name="chatbubbles-outline"></ion-icon></div>
                </div>
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $totalTestimonies; ?></div>
                        <div class="cardName">Testimonies</div>
                    </div>
                    <div class="iconBox"><ion-icon name="cash-outline"></ion-icon></div>
                </div>
            </div>

            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Orders</h2>
                        <a href="#" id="viewAllBtn" class="btn">View All</a>
                    </div>

                    <table id="bookingsTable" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Town</th>
                                <th>Area</th>
                                <th>Tool</th>
                                <th>Day</th>
                                <th>Booked At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr data-id="<?php echo $row['id']; ?>">
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><?php echo $row['town']; ?></td>
                                    <td><?php echo $row['area']; ?></td>
                                    <td><?php echo $row['service']; ?></td>
                                    <td><?php echo $row['day']; ?></td>
                                    <td><?php echo $row['booked_at']; ?></td>
                                    <td class="status"><?php echo $row['status']; ?></td>
                                    <td>
                                        <a style="color:red;text-decoration:none;" onclick="return confirm('Are you sure you want to delete?')" href="delete_booking.php?id=<?php echo $row['id']; ?>">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="js/main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   
    <script>
        $(document).ready(function() {
            $('.status').on('click', function() {
                var cell = $(this);
                var row = cell.closest('tr');
                var bookingId = row.data('id');
                var newStatus = cell.text() === 'attended' ? 'unattended' : 'attended';

                $.ajax({
                    url: 'update_booking_status.php',
                    type: 'POST',
                    data: {
                        id: bookingId,
                        status: newStatus
                    },
                    success: function(response) {
                        var res = JSON.parse(response);
                        if (res.success) {
                            cell.text(newStatus);
                        } else {
                            alert(res.message || 'Failed to update status');
                        }
                    },
                    error: function() {
                        alert('Error occurred while updating status');
                    }
                });
            });

            $('#viewAllBtn').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'fetchAllBooking.php',
                    type: 'GET',
                    success: function(response) {
                        $('#bookingsTable tbody').html(response);
                    },
                    error: function(xhr, status, error) {
                        alert('Error loading bookings');
                        console.log('AJAX error: ', error);
                        console.log('AJAX error details: ', xhr, status, error);
                    }
                });
            });
        });
    </script>
</body>
</html>
