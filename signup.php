<?php
$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $fname = $_POST["fname"];
    $mname = $_POST["mname"];
    $lname = $_POST["lname"];
    $username = $_POST["username"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $dob = $_POST["dob"];
    $address = $_POST["address"];
    $country = $_POST["country"];
    $state = $_POST["state"];
    $city = $_POST["city"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    // Check whether this username exists
    $existSql = "SELECT * FROM `Customers` WHERE FullName ='$username' OR email ='$email' OR phone ='$phone'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    if ($numExistRows > 0) {
        $showError = "Username or Email or Phone Number Already Exists";
    } else {
        // $exists = false;
        if (($password == $cpassword)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `Customers` (`FirstName`, `MiddleName`, `LastName`, `FullName`, `email`, `phone`, `dob`, `gender`, `address`, `country`,`state`,`city`, `password`) VALUES ('$fname', '$mname', '$lname', '$username', '$email', '$phone', '$dob', '$gender', '$address', '$country', '$state', '$city', '$hash');";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
                header("location: index.php");
                // exit;
            }
        } else {
            $showError = "Passwords do not match";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>SignUp Page</title>

</head>

<body>

    <?php require 'partials/_nav.php' ?>

    <?php
    // if ($showAlert) {
    //     echo ' <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
    //     <strong>Success!</strong> Your account is now created and you can login
    //     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    // </div>';
    // }
    if ($showError) {
        echo '<div class="position-fixed w-100 top-0 start-50 translate-middle-x" style="z-index: 1050; padding: 15px;">
                <div class="alert alert-danger alert-dismissible fade show text-center" role="alert" id="danger-alert" style="max-width: 500px; margin: auto;">
                    <strong>Error!</strong> ' . $showError . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>';
    }
    ?>


    <div class="container" style="margin-top: 63px;">
        <h1 class="text-center my-2">Signup to our website</h1>
        <form action="signup.php" autocomplete="on" method="post"
        
            style="display:flex;flex-direction:column;align-items:center" onsubmit="return validateForm()">
            <div class="mb-3 col-md-6">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" autofocus maxlength="15" class="form-control" id="fname" name="fname" required
                    placeholder="John">
            </div>
            <div class="mb-3 col-md-6">
                <label for="mname" class="form-label">Middle Name</label>
                <input type="text" maxlength="15" class="form-control" id="mname" name="mname" placeholder="Michael">
            </div>
            <div class="mb-3 col-md-6">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" maxlength="15" class="form-control" id="lname" name="lname" placeholder="Doe" required>
            </div>
            <div class="mb-3 col-md-6">
                <label for="username" class="form-label">Full Name</label>
                <input type="text" required maxlength="30" class="form-control" id="username" name="username"
                    placeholder="John Michael Doe(This is your UserId)"> 
            </div>
            <div class="mb-3 col-md-6">
                <label for="gender" class="form-label">Gender:</label>
                <label for="male">
                    <input type="radio" id="male" name="gender" value="male" required> Male
                </label>
                <label for="female">
                    <input type="radio" id="female" name="gender" value="female"> Female
                </label>
                <label for="other">
                    <input type="radio" id="other" name="gender" value="other"> Other
                </label>
            </div>
            <div class="mb-3 col-md-6">
                <label for="email" class="form-label">Email </label>
                <input type="email" placeholder="example@example.com" class="form-control" id="email" name="email"
                    required>

            </div>
            <div class="mb-3 col-md-6">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" name="phone" class="form-control" id="phone" name="phone" maxlength="10" required
                    pattern="[0-9]{10}" placeholder="Enter 10 digit number">

            </div>
            <div class="mb-3 col-md-6">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="mb-3 col-md-6">
                <label for="address" class="form-label">Address</label><br>
                <textarea id="address" name="address" rows="4" cols="50" class="form-control"
                    placeholder="Example-1234 Main St, City, State"></textarea required>
            </div>

            <!-- <div class="mb-3 col-md-6">
                <label for="country">Country</label>
                <select id="country" name="country" required class="form-control">
                    <option value="">Select your country</option>
                    <option value="india">India</option>
                    <option value="usa">United States</option>
                    <option value="uk">United Kingdom</option>
                    <option value="canada">Canada</option>
                </select>
            </div> -->

            <div class="select_option mb-3 col-md-6">
            <div class="my-2">
                <label for="country">Country</label>
                <select id="country" name="country" required class="form-control" onchange="loadStates()">
                    <option selected>Select your country</option>
                </select>
            </div>
            <div class="my-2">
                <label for="state">State</label>
                <select id="state" name="state" required class="form-control" onchange="loadCities()">
                    <option selected>Select your state</option>
                </select>
            </div>
            <div class="my-2">
                <label for="city">City</label>
                <select id="city" name="city" required class="form-control">
                    <option selected>Select your city</option>
                </select>
            </div> 
            </div>

            <div class="mb-3 col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" required maxlength="20" class="form-control" id="password" name="password" placeholder="Enter a strong password">
                
            </div>
            <div class="mb-3 col-md-6">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" required maxlength="20" class="form-control" id="cpassword" name="cpassword" placeholder="Re-enter your password">
            </div>

            <button type="submit" class="btn btn-primary col-md-2 mb-3">SignUp</button>
        </form>
    </div>


    <footer class="bg-dark text-center text-white">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            Thanks for Visting Our Webside
        </div>
    </footer>

    
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="src/signUpApi.js"></script>

    <script>
        setTimeout(function() {
            var alert = document.getElementById("success-alert");
            if (alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close(); // Close the alert after 5 seconds
            }
        }, 1000); // 5000 milliseconds = 5 seconds

        setTimeout(function() {
            var alert = document.getElementById("danger-alert");
            if (alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close(); // Close the alert after 5 seconds
            }
        }, 1000); // 5000 milliseconds = 5 seconds
    </script>



</body>

</html>