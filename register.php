<?php
ob_start(); // لضمان عدم إرسال أي محتوى قبل التوجيه
include "config.php"; // الاتصال بقاعدة البيانات
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SB Admin 2 - Register</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700,900" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row" style="display: flex; align-items: center;">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"
                        style="display: flex; justify-content: center; align-items: center;">
                        <img src="img/image-removebg-preview.png" alt="Dentist Image" class="img-fluid mb-4"
                            style="max-width: 300px; margin-top: 20px; margin-left: 70px;">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" action="" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="first_name" class="form-control form-control-user"
                                            placeholder="First Name" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="last_name" class="form-control form-control-user"
                                            placeholder="Last Name" required>
                                    </div>
                                    <div class="col-sm-6"><br>
                                        <input type="tel" name="phone" class="form-control form-control-user"
                                            placeholder="Phone Number" required>
                                    </div>
                                    <div class="col-sm-6"><br>
                                        <input type="date" name="dob" class="form-control form-control-user"
                                            placeholder="Date of Birth" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user"
                                        placeholder="Email Address" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <select name="gender" class="form-control form-control-user" required>
                                            <option value="" disabled selected>Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            placeholder="Password" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">Register</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Developer. Ali Albanna. 2025</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $firstName = $_POST['first_name'];
        $lastName  = $_POST['last_name'];
        $phone     = $_POST['phone'];
        $dob       = $_POST['dob'];
        $email     = $_POST['email'];
        $gender    = $_POST['gender'];
        $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO patients (first_name, last_name, phone, birth_date, email, gender, password)
                                VALUES (:first_name, :last_name, :phone, :dob, :email, :gender, :password)");
        $stmt->execute([
            ':first_name' => $firstName,
            ':last_name'  => $lastName,
            ':phone'      => $phone,
            ':dob'        => $dob,
            ':email'      => $email,
            ':gender'     => $gender,
            ':password'   => $password
        ]);

        header("Location: medical-history-register.php?email=$email");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
ob_end_flush();
?>
