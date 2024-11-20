<?php

$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = " Select * from admin where adminName='$username'  AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
       header("location: adminPage.php");    
    } else {
        $showError = "Invalid Admin Credentials";
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

    <title>Admin Login Page</title>
    <style>
        html,body {
            overflow: hidden;/* Hides the scrollbar */
            height: 100%;/* Ensures full height */
            margin: 0;/* Removes default margin */
        }
        .container {
            min-height: calc(100vh - 30vh);
        }
    </style>

</head>

<body>
    <div class="am">
        <?php require 'partials/_nav.php' ?>
    </div>

    <?php
    if ($showError) {
    echo '<div class="position-fixed w-100 top-0 start-50 translate-middle-x" style="z-index: 1050; padding: 15px;">
    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert" id="danger-alert" style="max-width: 500px; margin: auto;">
        <strong>Error!</strong> ' . $showError . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>';
    }

    ?>

    <div class="container" style="margin-top: 150px;">
        <h1 class="text-center my-2 mt-500">Admin Login</h1>
        <form action="admin.php" autocomplete="on" method="post"
            style="display:flex;flex-direction:column;align-items:center">
            <div class="mb-3 col-md-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" required autofocus maxlength="30" class="form-control" id="username"
                    aria-describedby="emailHelp" name="username" placeholder="Enter your AdminId">
            </div>
            <div class="mb-3 col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" required maxlength="20" class="form-control" id="password" name="password" placeholder="Enter your password">
            </div>

            <button type="submit" class="btn btn-primary col-md-2 my-3">Login</button>
        </form>
    </div>

    <footer class="bg-dark text-center text-white con">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            Thanks for Visting Our Webside
        </div>
    </footer>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script>
        setTimeout(function() {
            var alert = document.getElementById("danger-alert");
            if (alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();  // Close the alert after 5 seconds
            }
        }, 1000);  // 5000 milliseconds = 5 seconds
    </script>


</body>

</html>