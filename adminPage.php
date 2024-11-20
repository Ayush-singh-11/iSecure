<?php
$update = false;
$delete = false;
include 'partials/_dbconnect.php';
$sql = " Select * from Customers where FullName='$username'";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);

if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $sql = "DELETE FROM `Customers` WHERE `sno` = $sno";
    $result = mysqli_query($conn, $sql);
    $delete = true;
    header("location: adminPage.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        // Update the record
        $sno = $_POST["snoEdit"];
        $fname = $_POST["fname"];
        $mname = $_POST["mname"];
        $lname = $_POST["lname"];
        $username = $_POST["titleEdit"];
        // Sql query to be executed
        $sql = "UPDATE `Customers` SET `FirstName` = '$fname', `MiddleName` = '$mname', `LastName` = '$lname',`FullName` = '$username'  WHERE `sno` = $sno";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION["username"] = $username;
            $update = true;
        } else {
            echo "We could not update the record successfully";
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

    <title>Admin Page</title>
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

    <style>
    .me {
        margin-bottom: 42vh;
    }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height: 70px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="adminPage.php">iSecure</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="admin.php">Logout</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Usernames</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="adminPage.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="form-group my-2">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" autofocus maxlength="15" class="form-control" id="fname" name="fname">
                        </div>
                        <div class="form-group my-2">
                            <label for="mname" class="form-label">Middle Name</label>
                            <input type="text" maxlength="15" class="form-control" id="mname" name="mname">
                        </div>
                        <div class="form-group my-2">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" maxlength="15" class="form-control" id="lname" name="lname">
                        </div>
                        <div class="form-group my-2">
                            <label for="title">Username</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit"
                                aria-describedby="emailHelp" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php
    if ($delete) {
        echo '<div class="position-fixed w-100 top-0 start-50 translate-middle-x" style="z-index: 1050; padding: 15px;">
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert" id="success-alert" style="max-width: 500px; margin: auto;">
                <strong>Success!</strong> Your data has been deleted successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            </div>';
    }
    ?>

    <?php
    if ($update) {
        echo '<div class="position-fixed w-100 top-0 start-50 translate-middle-x" style="z-index: 1050; padding: 15px;">
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert" id="success-alert" style="max-width: 500px; margin: auto;">
            <strong>Success!</strong> Your data has been updated successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>';
    }
    ?>


    <div class="container text-center" style="margin-top:135px">
        <h3>List of Users</h3>
    </div>

    <div class="container"></div>
    <table class="table" id="myTable">
        <hr>
        <thead>
            <tr>
                <th scope="col">S.No</th>
                <th scope="col">Username</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM `Customers`";
            $result = mysqli_query($conn, $sql);
            $sno = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $sno = $sno + 1;
                echo "<tr>
                            <th scope='row'>" . $sno . "</th>
                            <td >" . $row['FullName'] . "</td>
                            <td> 
                            <button class='edit btn btn-sm btn-primary'
                            data-fname='" . $row['FirstName'] . "'
                            data-mname='" . $row['MiddleName'] . "'
                            data-lname='" . $row['LastName'] . "'
                            data-fullname='" . $row['FullName'] . "'
                            id=" . $row['sno'] . ">Edit</button>

                            <button class='delete btn btn-sm btn-primary' id=d" . $row['sno'] . ">Delete</button> 

                            </td>
                        </tr>
                        ";
            }
            ?>
        </tbody>
    </table>
    <hr>
    </div>

    <div class="me"></div>


    <footer class="bg-dark text-center text-white">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            Thanks for Visting Our Webside
        </div>
    </footer>


    <!-- Used for creating dynamic table -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
    </script>
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script>
    let table = new DataTable('#myTable');
    </script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>


    <script>
    setTimeout(function() {
        var alert = document.getElementById("danger-alert");
        if (alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close(); // Close the alert after 5 seconds
        }
    }, 1000); // 5000 milliseconds = 5 seconds
    </script>

    <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            // console.log("edit ");

            // tr = e.target.parentNode.parentNode;
            // console.log(tr);
            // let title = tr.getElementsByTagName("td")[0].innerText;

            // Get the data attributes
            let fnamejs = e.target.getAttribute("data-fname");
            let mnamejs = e.target.getAttribute("data-mname");
            let lnamejs = e.target.getAttribute("data-lname");
            let fullNamejs = e.target.getAttribute("data-fullname");
            console.log(fullNamejs, fnamejs, mnamejs, lnamejs);

            // Set values in the modal fields
            fname.value = fnamejs;
            mname.value = mnamejs;
            lname.value = lnamejs;
            titleEdit.value = fullNamejs;

            // Set the snoEdit field with the row's ID
            snoEdit.value = e.target.id;
            // console.log(e.target.id,snoEdit.value);

            // Open the modal
            $('#editModal').modal('toggle');
        })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            // console.log("edit ");
            sno = e.target.id.substr(1);

            if (confirm("Are you sure you want to delete this User!")) {
                console.log("yes");
                window.location = `/iSecure/adminPage.php?delete=${sno}`;
            } else {
                console.log("no");
            }
        })
    })
    </script>

</body>

</html>