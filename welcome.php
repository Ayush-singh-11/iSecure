<?php
session_start();
$row = null;
$update = false;
$delete = false;
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: index.php");
    exit;
} else {

    include 'partials/_dbconnect.php';

    $username = $_SESSION['username'];
    $sql = " Select * from Customers where FullName='$username'";
    $result = mysqli_query($conn, $sql);
    // $num=mysqli_num_rows($result);
    // echo "$num Records found in the DataBase<br>";
    $row = mysqli_fetch_assoc($result);
    $countryValue = $row["country"];
    $stateValue = $row["state"];
    $cityValue = $row["city"];
    // echo $ctr;
    // echo var_dump($row);
    // echo $row['sno'];

    //Delete data from db
    if (isset($_GET['delete'])) {
        $sno = $row['sno'];
        $delete = true;
        $sql = "DELETE FROM `Customers` WHERE `sno` = '$sno'";
        $result = mysqli_query($conn, $sql);
        header("location: signup.php");
        exit;
    }

    //Update data from db
    if (isset($_POST['snoEdit'])) {
        // Update the record
        $sno = $row['sno'];
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

        // Sql query to be executed
        $sql = "UPDATE `Customers` SET `FirstName` = '$fname', `MiddleName` = '$mname', `LastName` = '$lname', `FullName` = '$username', `email` = '$email', `phone` = '$phone', `dob` = '$dob', `gender` = '$gender', `address` = '$address', `country` = '$country', `state` = '$state', `city` = '$city' WHERE `sno` = '$sno' ;";
        $result = mysqli_query($conn, $sql);
        $sql = " Select * from Customers where FullName='$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $_SESSION["username"] = $username;
        $update = true;
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

    <title>Welcome -<?php echo $_SESSION['username'] ?></title>

    <!-- <style>
        .con {
            align-text:center;
            text-align: center;
            margin-top: 75px;
            margin-bottom: 30px;
        }

        .box {
            /* border-collapse: collapse; */
            display: flex;
            align-items: center;
            justify-content: center;
            /* height: 40vh; */
        }

        th,
        td {
            padding: 8px;
            width: 400px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* tr:hover {background-color: coral;} */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style> -->

    <style>
    .con {
        /* align-text: center; */
        text-align: center;
        margin-top: 75px;
        margin-bottom: 30px;
    }

    .table th,
    .table td {
        vertical-align: middle;
        padding: 15px;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-striped tbody tr:nth-of-type(even) {
        background-color: #fff;
    }

    .table-bordered {
        border: 2px solid #dee2e6;
    }

    .box {
        width: 100%;
        max-width: 800px;
        margin: auto;
        margin-top: 20px;
        border-radius: 8px;
    }
    </style>

</head>

<body>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="welcome.php" autocomplete="on" method="post"
                        style="display:flex;flex-direction:column;align-items:center">
                        <input type="hidden" name="snoEdit" id="snoEdit" value="1"> <!-- Hidden field for record ID -->
                        <div class="mb-3 col-md-6">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" autofocus maxlength="15" class="form-control" id="fname" name="fname"
                                required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="mname" class="form-label">Middle Name</label>
                            <input type="text" maxlength="15" class="form-control" id="mname" name="mname">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" maxlength="15" class="form-control" id="lname" name="lname">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="username" class="form-label">Full Name</label>
                            <input type="text" required maxlength="30" class="form-control" id="username"
                                name="username">
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
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" id="phone" name="phone" maxlength="10"
                                required pattern="[0-9]{10}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Address</label><br>
                            <textarea id="address" name="address" rows="4" cols="50" class="form-control"></textarea required>
                        </div>

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

            <!-- <button type="submit" class="btn btn-primary col-md-2 mb-3">Update</button> -->

            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
        </form>
                </div>
                
            </div>
        </div>
    </div>


    <?php require 'partials/_nav.php' ?>

    <?php
    if ($update) {
        // echo '<div class="container mt-3">
        // <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        // <strong>Success!</strong>Your note has been updated successfully<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        // </div>
        // </div>';

        echo '<div class="position-fixed w-100 top-0 start-50 translate-middle-x" style="z-index: 1050; padding: 15px;">
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert" id="success-alert" style="max-width: 500px; margin: auto;">
            <strong>Success!</strong> Your data has been updated successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>';
    }
    ?>
    
    <div class="container  mt-5">
    <div class="con">
        <h3>Welcome to Home Page <?php echo $_SESSION['username'] ?></h3>
    </div>
    <?php
    // Assuming $row['FirstName'] is coming from some database query
    // $a = $row["FirstName"]; // Assign the value from $row array to $a
    echo '
    <div class="box">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Field</th>
                    <th scope="col">Data</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>First Name</td>
                    <td class="d1">' . htmlspecialchars($row["FirstName"]) . '</td>
                </tr>
                <tr>
                    <td>Middle Name</td>
                    <td class="d1">' . htmlspecialchars($row["MiddleName"]) . '</td> 
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td class="d1">' . htmlspecialchars($row["LastName"]) . '</td> 
                </tr>
                <tr>
                    <td>Full Name</td>
                    <td class="d1">' . htmlspecialchars($row["FullName"]) . '</td> 
                </tr>
                <tr>
                    <td>Email</td>
                    <td class="d1">' . htmlspecialchars($row["email"]) . '</td> 
                </tr>
                <tr>
                    <td>Phone</td>
                    <td class="d1">' . htmlspecialchars($row["phone"]) . '</td> 
                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td class="d1">' . htmlspecialchars($row["dob"]) . '</td> 
                </tr>
                <tr>
                    <td>Gender</td>
                    <td class="d1">' . htmlspecialchars($row["gender"]) . '</td> 
                </tr>
                <tr>
                    <td>Address</td>
                    <td class="d1">' . htmlspecialchars($row["address"]) . '</td> 
                </tr>
                <tr>
                    <td>Country</td>
                    <td class="d1">' . htmlspecialchars($row["country"]) . '</td> 
                </tr>
                <tr>
                    <td>State</td>
                    <td class="d1">' . htmlspecialchars($row["state"]) . '</td> 
                </tr>
                <tr>
                    <td>City</td>
                    <td class="d1">' . htmlspecialchars($row["city"]) . '</td> 
                </tr>
            </tbody>
        </table>
    </div>';

    ?>
    </div>

    

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                let fnamejs = document.getElementsByClassName('d1')[0].innerText;
                let mnamejs = document.getElementsByClassName('d1')[1].innerText;
                let lnamejs = document.getElementsByClassName('d1')[2].innerText;
                let fullnamejs = document.getElementsByClassName('d1')[3].innerText;
                let emailjs = document.getElementsByClassName('d1')[4].innerText;
                let phonejs = document.getElementsByClassName('d1')[5].innerText;
                let dobjs = document.getElementsByClassName('d1')[6].innerText;
                let genderjs = document.getElementsByClassName('d1')[7].innerText;
                let addressjs = document.getElementsByClassName('d1')[8].innerText;
                // let countryjs = document.getElementsByClassName('d1')[9].innerText;
                // let statejs = document.getElementsByClassName('d1')[10].innerText;
                // let cityjs = document.getElementsByClassName('d1')[11].innerText;
                // console.log("edit", fnamejs, mnamejs, lnamejs, fullnamejs, emailjs, phonejs, dobjs, genderjs, addressjs, countryjs,statejs,cityjs);
                fname.value = fnamejs;
                mname.value = mnamejs;
                lname.value = lnamejs;
                username.value = fullnamejs;
                // Set gender radio button based on the gender value
                if (genderjs === "male") {
                    document.getElementById("male").checked = true;
                } else if (genderjs === "female") {
                    document.getElementById("female").checked = true;
                } else if (genderjs === "other") {
                    document.getElementById("other").checked = true;
                }
                email.value = emailjs;
                phone.value = phonejs;
                dob.value = dobjs;
                address.value = addressjs;
                // Set the country, state, and city values using the PHP variables
                // document.getElementById("country").value = "<?php //echo $countryValue; ?>";
                // Call these functions before setting the values
                // loadStates();  // Load states based on the country
                // loadCities();  // Load cities based on the state
                // document.getElementById("state").value = "<?php //echo $stateValue; ?>";
                // document.getElementById("city").value = "<?php //echo $cityValue; ?>";
                // country.value = countryjs;
                // state.value = statejs;
                // city.value = cityjs;
                // console.log(state.value,city.value);
                
                
                // Initialize the modal
                var editModal = new bootstrap.Modal(document.getElementById('editModal'), {
                    keyboard: false
                });
                // editModal.toggle();
                editModal.show();
                // console.log(snoEdit.value);
                // console.log(typeof snoEdit.value);
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                if (confirm("Are you sure you want to delete this Userdata!")) {
                    console.log("yes");
                    window.location = `welcome.php?delete=true`;
                }
                else {
                    console.log("no");
                }

            })
        })

    </script>

    <script src="src/welcomeApi.js"></script>

    <script>
        setTimeout(function() {
            var alert = document.getElementById("success-alert");
            if (alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();  // Close the alert after 5 seconds
            }
        }, 1000);  // 5000 milliseconds = 5 seconds
    </script>


</body>

</html>