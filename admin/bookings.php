<?php
        session_start();
        if(!isset($_SESSION["user_id"])){
          header('Refresh:0; login.php');
          die();

        }
        //create a connectin to db
        $conn= mysqli_connect('localhost','root','','userdatabase');
        if(!$conn){
            die("unable to connect");
            exit;
        }else{
            
                //echo "connected successfully ";
            
        }
        $query = "SELECT * FROM bookingdata";
$result = $conn->query($query);

// Fetch total count of bookings from bookingdata
$countQuery = "SELECT COUNT(*) as total FROM bookingdata";
$countResult = $conn->query($countQuery);
$countRow = $countResult->fetch_assoc();
$totalBookings = $countRow['total'];

//Fetch Total number of Messages stored from contacts table
$countQuery1 = "SELECT COUNT(*) as total FROM contacts";
$countResult1 = $conn->query($countQuery1);
$countRow1 = $countResult1->fetch_assoc();
$totalMessages = $countRow1['total'];

//Fetch Total number of Testimonies stored into testimonies table
$countQuery2 = "SELECT COUNT(*) as total FROM testimonies";
$countResult2 = $conn->query($countQuery2);
$countRow2 = $countResult2->fetch_assoc();
$totalTestimonies = $countRow2['total'];
?>
       

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin panel</title>
    <!--=====STYLES-->
    <link rel="stylesheet" href="css/mystyles.css" />
  </head>
  <body>
    <div class="ses">
      <h2>welcome
    <?php
        echo $_SESSION['username'];
    ?>
    </h2>
    <!-- =====Navigation===== -->
    <div class="container">
      <div class="navigation">
        <ul>
          <li>
            <a href="">
              <span class="icon"><ion-icon name="logo-apple"></ion-icon> </span>
              <span class="title">Brand Name</span>
            </a>
          </li>
          <li>
            <a href="">
              <span class="icon"
                ><ion-icon name="home-outline"></ion-icon>
              </span>
              <span class="title">Dashboard</span>
            </a>
          </li>
          <li>
            <a href="">
              <span class="icon"
                ><ion-icon name="people-outline"></ion-icon
              ></span>
              <span class="title">Customers</span>
            </a>
          </li>
          <li>
            <a href="">
              <span class="icon"
                ><ion-icon name="chatbubble-ellipses-outline"></ion-icon
              ></span>
              <span class="title">Messages</span>
            </a>
          </li>
          <li>
            <a href="">
              <span class="icon"
                ><ion-icon name="help-outline"></ion-icon
              ></span>
              <span class="title">Help</span>
            </a>
          </li>
          <li>
            <a href="">
              <span class="icon"
                ><ion-icon name="settings-outline"></ion-icon
              ></span>
              <span class="title">Settings</span>
            </a>
          </li>
          <li>
            <a href="updatePassword.php">
              <span class="icon"
                ><ion-icon name="lock-open-outline"></ion-icon
              ></span>
              <span class="title">Change password</span>
            </a>
          </li>
          <li>
            <a href="logout.php">
              <span class="icon"
                ><ion-icon name="log-out-outline"></ion-icon
              ></span>
              <span class="title">Sign Out</span>
            </a>
          </li>
        </ul>
      </div>

      <!--=======MAIN========-->
      <div class="main">
        <div class="topbar">
          <div class="toggle">
            <ion-icon name="menu-outline"></ion-icon>
          </div>
          <div class="search">
            <label>
              <input type="text" placeholder="search here" />
              <ion-icon name="search-outline"></ion-icon>
            </label>
          </div>
          <div class="user">
            <img src="assets/imgs/ds.jpg" alt="user img" />
          </div>
        </div>
        <!--========CARDS========-->
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
              <div class="numbers">80</div>
              <div class="cardName">Sales</div>
            </div>
            <div class="iconBox"><ion-icon name="cart-outline"></ion-icon></div>
          </div>
          <div class="card">
            <div>
              <div class="numbers"><?php echo $totalTestimonies; ?></div>
              <div class="cardName">Testimonies</div>
            </div>
            <div class="iconBox">
              <ion-icon name="chatbubbles-outline"></ion-icon>
            </div>
          </div>
          <div class="card">
            <div>
              <div class="numbers"><?php echo $totalMessages; ?></div>
              <div class="cardName">Messages</div>
            </div>
            <div class="iconBox"><ion-icon name="cash-outline"></ion-icon></div>
          </div>
        </div>
        <!--=========Order Details==========-->

        <div class="details">
          <div class="recentOrders">
            <div class="cardHeader">
              
              <h2>Recent Orders</h2>

              <a href="#" id="loadMoreBtn" class="btn">Previous Week</a>
              <!-- <button id="loadMoreBtn" class="btn btn-primary">Load Previous Week</button> -->
            </div>
           
            <table id="bookingsTable" class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>phone</th>
            <th>town</th>
            <th>area</th>
            <th>Tool</th>
            <th>Day</th>
            <th>booked_at</th>
            <th>status</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
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
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
          </div>
         
        </div>
      </div>
    </div>
    <!--======JS SCRIPTS-->
    <script src="js/main.js"></script>
    <!--=======IONICON LINK=====-->
    <script
      type="module"
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
    ></script>
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
                if (response === 'success') {
                    cell.text(newStatus);
                } else {
                    alert('Error updating status');
                    console.log('Server response: ', response);
                }
            },
            error: function(xhr, status, error) {
                alert('AJAX error: ' + error);
                console.log('AJAX error details: ', xhr, status, error);
            }
        });
    });
});

</script>

  </body>
</html>
