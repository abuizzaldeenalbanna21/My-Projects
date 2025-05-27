<?php
ob_start();
session_start();
include "database.php";

$db = new Database($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // hash the password
    $type = $_POST["specialty"];
    $phone = $_POST["phone"];

    // Insert new user
    $data = [
        "full_name" => $full_name,
        "email" => $email,
        "password" => $password,
        "specialty" => $type,
        "phone" => $phone,
    ];

    $db->insert("doctors", $data);
    header("Location: users.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Add Doctor</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include 'sidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'navbar.php'; ?>

                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 text-gray-800">Add Doctor</h1>
                        <a href="users.php" class="btn btn-secondary btn-circle"><i class="fas fa-arrow-left"></i></a>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" name="full_name"
                                            placeholder="Enter First Name" required>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Enter Email"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Enter Password" required>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    id="togglePassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="specialty">specialty</label>
                                        <input type="text" class="form-control" name="specialty" id="specialty"
                                            placeholder="Enter Specialty" value="">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" name="phone"
                                            placeholder="Enter Phone Number">
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary" style="width: 250px;">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; Developed by Ali Albanna 2025</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const pwd = document.getElementById('password');
            const icon = this.querySelector('i');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                pwd.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    </script>
</body>

</html>