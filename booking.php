
<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header('Refresh:0; index.html');
    die();
}
// include ('config/connect.php');
$connection = mysqli_connect('localhost','root','','userdatabase');
$errorMessage="";
$successMessage="";
// $name="";$email="";$phone="";$address="";
 if ($_SERVER['REQUEST_METHOD']=="POST"){

  $fullname=$_POST['fullname'];
  $email=$_POST['email'];
  $phone=$_POST['phone'];
   $town=$_POST['town'];
  $area=$_POST['area'];
  $service=$_POST['service'];
 $day=$_POST['day'];

  //using sql prepared statements below instead of sql queries to avoid sql injections and other threats
  //$connection variable represents the mysqli object
 $preparedQuery = $connection->prepare("INSERT INTO bookingData (fullname, email, phone, town, area, service, day) VALUES (?, ?, ?, ?, ?, ?, ?)");
 $preparedQuery->bind_param("sssssss", $fullname, $email, $phone, $town, $area, $service, $day,);
 $preparedQuery->execute();
 
 
  // $sql="INSERT INTO bookingData(fullname,email,phone,town,area,service,day)  VALUES ('$fullname','$email','$phone','$town','$area','$service','$day')";
  //   $result=$connection->query($sql);
    //  if(!$result){
    //    $errorMessage="failed to insert";
    //  }else{
      if($preparedQuery->error){
        $errorMessage="booking failed.Try Again!".$preparedQuery->error;
        exit;
      }else{
      echo
     " <script> alert('Successfully booked! Redirecting you to homepage');</script>";
      
    header('Refresh: 0; URL=index.html');
    
     }
     $preparedQuery->close(); 
  }
  
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh;"> <!-- Center vertically and horizontally -->
        <div class="card col-md-8"> 
            <div class="card-header bg-primary text-white">
            <h2 class="text-center text-sm">Booking Form</h2>

            </div>
            <div class="card-body">
                <form method="POST" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="fullname">Full Name:</label>
                        <input type="text" class="form-control" id="fullname" placeholder="Enter full name" name="fullname" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="tel" class="form-control" id="phone" placeholder="Enter phone number (07xxxxxxxx)" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="town">Select your town:</label>
                        <select class="form-control" id="town" name="town" required>
                            <option value="Kiserian" selected>Kiserian</option>
                            <option value="ngong">Kahuho</option>
                            <option value="Kiserian">Matasia</option>
                            <option value="Kiserian">Gishagi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="area">Specific Area:</label>
                        <input type="text" class="form-control" id="area" placeholder="Enter specific area" name="area" required>
                    </div>
                    <div class="form-group">
                        <label for="service">Tool Type:</label>
                        <select class="form-control" id="service" name="service" required>
                            <option value="Knife" selected>Knife</option>
                            <option value="Panga">Panga</option>
                            <option value="Axe">Axe</option>
                            <option value="Machette">Machette</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="day">Service Day:</label>
                        <input type="date" class="form-control" id="day" name="day" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function validateForm() {
            var phone = document.getElementById("phone").value;
            var email = document.getElementById("email").value;

            // Phone number validation
            var phonePattern = /^(07|01)\d{8}$/; // Matches "07" or "01" followed by 8 digits
            if (!phonePattern.test(phone)) {
                alert("Please enter a valid phone number starting with '07' or '01'.");
                return false; // Prevent form submission
            }

            // Email address validation
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email pattern
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false; // Prevent form submission
            }

            // If both phone number and email are valid, allow form submission
            return true;
        }
    </script>
</body>
</html>

