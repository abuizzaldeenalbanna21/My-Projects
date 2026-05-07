<?php
ob_start();
session_start();
include "config.php";
include "database.php";



if (isset($_SESSION['user_email']) && isset($_SESSION['user_type'])) {
    header("Location: index_admin.php");
    exit;
}



// معالجة تسجيل الدخول
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $user = null;
        $id = null;
        $userType = null;
        $stmt = $conn->prepare("SELECT * FROM doctors WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($doctor && password_verify($password, $doctor['password'])) {
            $id = $doctor["id"];
            $user = $doctor;
            $userType = 'doctor';
            $fullName = $doctor['full_name'];
            $profile_image = $doctor['profile_image'];
            ;
        }
        // 2. If not a patient, check doctors table
        if (!$user) {


            // 1. Check patients table
            $stmt = $conn->prepare("SELECT * FROM patients WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $email]);
            $patient = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($patient) {
                if (password_verify($password, $patient['password'])) {
                    $user = $patient;
                    $id = $user["id"];
                    $profile_image = $patient["profile_image"];
                    $userType = 'patient';
                    $fullName = $patient['first_name'] . ' ' . $patient['last_name'];
                }
            }
        }

        // 3. If user is found and password is correct
        if ($user) {
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['name'] = $fullName;
            $_SESSION['user_type'] = $userType;
            $_SESSION['profile_image'] = $profile_image;
            $_SESSION['id'] = $id;
            header(header: "Location: index_admin.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        $error = "Database Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dental Clinic - Login</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-flex justify-content-center">
                                <img src="img/image-removebg-preview.png" alt="Dentist Image" class="img-fluid mb-4"
                                    style=" margin-top: 20px;">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome to our Dental Clinic</h1>
                                    </div>

                                    <?php if (isset($error)){
                                        echo "<div class='alert alert-danger text-center'>$error</div>";} ?>

                                    <form class="user" action="" method="post">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                placeholder="Enter Email Address..." required>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="password" name="password"
                                                    class="form-control form-control-user" id="exampleInputPassword"
                                                    placeholder="Password" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        id="togglePassword">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                    </form>

                                    <div class="text-center mt-3">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                    <div class="text-center mt-3">
                                        <a class="small" href="index.html">Home</a>
                                    </div>
                                    <footer class="sticky-footer bg-white mt-4">
                                        <div class="container my-auto">
                                            <div class="copyright text-center my-auto">
                                                <span>Copyright &copy; Developer. Ali Albanna. 2025</span>
                                            </div>
                                        </div>
                                    </footer>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('exampleInputPassword');
            const icon = this.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>