
<?php
include('config/connect.php');
$errorMessage="";
if($_SERVER['REQUEST_METHOD']=="POST"){
    $fname=$_POST['fname'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $message=$_POST['message'];
    $preparedQuery = $connection->prepare("INSERT INTO contacts (fname, email, phone,message) VALUES (?, ?, ?,?)");
    $preparedQuery->bind_param("ssis",$fname,$email,$phone,$message);
    $preparedQuery->execute();
         if($preparedQuery->error){
           $errorMessage="failed to insert".$preparedQuery->error;
           exit;
         }else{
         echo
        " <script> alert('Successfully booked! Redirecting you to homepage');</script>";
       header('Refresh: 0; URL=index.html'); // Redirect after 0 seconds
       
        }
        $preparedQuery->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact us</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="contact.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-7">
            <!--for screen sizes between 768px to 991px Thiss= means it will take 7 out 12 column width -->
            <h4>Get in Touch</h4>
        <form method="POST" onsubmit="return validateForm()">
        <div class="mb-3">
            <!-- this div mb means margin from bottom to be 3 in a scale of 5 -->
        <label for="fname">Name</label>
    <input type="text" class="form-control" id="fname" name="fname" placeholder="enter your name" required="">
        </div>
        <div class="mb-3">
        <label for="email">Email address</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="enter your email" required="">
        </div>
        <div class="mb-3">
        <label for="phone">phone</label>
    <input type="tel" class="form-control" id="phone" name="phone" placeholder="enter phone number" required="">
        </div>
        <div class="mb-3">
        <label for="textarea">message</label>
    <textarea class="form-control" id="textarea" placeholder="type your message" name="message" rows="3" required=""></textarea>
        </div>
        <button class="btn btn-primary">Submit</button>
</div>
</form>
        <div class="col-md-5">
        <!-- md-5: This specifies the column width for medium-sized screens (between 768px and 991px).
         In this case, md-5 means the column should take up 5 out of 12 available columns -->

<h4>Contact us</h4><hr>
<!-- <hr> element creates a horizontal line between 
the paragraphs to visually indicate a separation between them. -->
<div class="mt-5">
<!-- mt: This stands for margin top.
5: This number represents the size of the margin -->
    <div class="d-flex">
        <!-- this div class d-flex instructs the browser that the content in the div will be a flexbox i.e
        displayed on the same row -->
    <i class="bi bi-geo-alt"></i>
    <p>address: 00206 Kiserian, kenya</p>
    </div> <hr>
   
    <div class="d-flex">
    <i class="bi bi-telephone-fill"></i>
    <p>: 0727390238</p>
    <p>/0731354901</p>
    </div> <hr>
    <div class="d-flex">
    <i class="bi bi-envelope"></i>
    <p>:i.mwangi@silaiproperties.net</p>
    </div> <hr>
    <div class="d-flex">
    <i class="bi bi-browser-chrome"></i>
    <p>: wwww.silaiproperties.net</p>
    </div> <hr>
</div>
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