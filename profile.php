<?php
ob_start();
session_start();
include "database.php";

$userType = $_SESSION['user_type'] ?? '';
$name = $_SESSION['name'] ?? '';
$id = $_SESSION['id'] ?? '';

$db = new Database($conn);

$dataProfile = $db->select("patients" , "id=?" , [$id])[0];

$message = '';
$message_type = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $age = $_POST['age'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Handle profile image
    if (!empty($_FILES['profile_image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['profile_image']['name']);
        $target_path = "uploads/" . $image_name;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_path);
    } else {
        $image_name = $dataProfile['profile_image'] ?? '';
    }

    // Prepare update query and parameters
    $updateQuery = "UPDATE patients SET first_name = :first_name, last_name = :last_name, email = :email, age = :age, phone = :phone, profile_image = :profile_image";
    $params = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'age' => $age,
        'phone' => $phone,
        'profile_image' => $image_name,
        'id' => $id
    ];

    // Password update logic
    if (!empty($current_password) || !empty($new_password) || !empty($confirm_password)) {
        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $message = "Please fill in all password fields.";
            $message_type = 'danger';
        } elseif (!password_verify($current_password, $dataProfile['password'])) {
            $message = "Current password is incorrect.";
            $message_type = 'danger';
        } elseif ($new_password !== $confirm_password) {
            $message = "New password and confirmation do not match.";
            $message_type = 'danger';
        } else {
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
            $updateQuery .= ", password = :password";
            $params['password'] = $hashedPassword;
        }
    }

    // If no error, update the database
    if ($message_type !== 'danger') {
        $updateQuery .= " WHERE id = :id";
        $stmt = $conn->prepare($updateQuery);
        $stmt->execute($params);

        $message = "تم تحديث البيانات بنجاح.";
        $message_type = 'success';

        // Refresh profile data
        $dataProfile = $db->select("patients", "id=?", [$id])[0];
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dental Clinic - Profile</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,400,700" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        #accordionSidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
            z-index: 1030;
        }

        #content-wrapper {
            margin-left: 250px;
        }

        @media (max-width: 768px) {
            #accordionSidebar {
                position: relative;
                height: auto;
            }

            #content-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">
        <?php include 'sidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'navbar.php'; ?>

                <!-- حذف الكارد الخارجي -->
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-4 text-gray-800">Profile</h1>
                    <a href="index_admin.php" class="btn btn-circle btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>

                <div class="col-12">
                    <form class="card shadow p-4 w-100" method="POST" enctype="multipart/form-data">
                        <h5 class="card-title mb-3">Edit Your Information</h5>
                        <div class="row align-items-center">
                            <!-- صورة البروفايل -->
                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <div class="card shadow w-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Your Image</h5>
                                        <label for="profileImageUpload">
                                        <img id="previewImage" src="<?= !empty($dataProfile['profile_image']) ? 'uploads/' . htmlspecialchars($dataProfile['profile_image']) : 'img/undraw_profile.svg' ?>"
                                        alt="Profile Image"
                                        class="img-fluid rounded-circle mb-3"
                                        style="width: 150px; height: 150px; cursor: pointer;">
                                        </label>
                                        <input type="file" id="profileImageUpload" name="profile_image" accept="image/*" style="display: none;">
                                        <p class="text-muted">Click on the image to upload a new one</p>
                                    </div>
                                </div>
                            </div>
                            <!-- مدخلات النموذج -->
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="userName">First Name</label>
                                        <input type="text" name="first_name" value="<?= htmlspecialchars($dataProfile['first_name']) ?>" class="form-control" id="userName" placeholder="Enter your user name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="userName">last Name</label>
                                        <input type="text" name="last_name" value="<?= htmlspecialchars($dataProfile['last_name']) ?>" class="form-control" id="userName" placeholder="Enter your user name">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="userEmail">Email</label>
                                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($dataProfile['email']) ?>" id="userEmail" placeholder="Enter your email">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="userBirthday">Birthday</label>
                                        <input type="date" name="age" class="form-control" value="<?= htmlspecialchars($dataProfile['birth_date']) ?>" id="userBirthday">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="userPhone">Phone Number</label>
                                        <input type="tel" name="phone" class="form-control" id="userPhone" value="<?= htmlspecialchars($dataProfile['phone']) ?>"  placeholder="Enter your phone number">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="currentPassword">Current Password</label>
                                        <div class="input-group">
                                            <input type="password" name="current_password" class="form-control"  id="currentPassword" placeholder="Enter current password">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#currentPassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="newPassword">Change Password</label>
                                        <div class="input-group">
                                            <input type="password" name="new_password" class="form-control" id="newPassword" placeholder="Enter new password">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#newPassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" name="confirm_password" class="form-control" id="confirmPassword" placeholder="Confirm new password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#confirmPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- زر الحفظ في منتصف الكارد -->
                            <div class="col-12">
                                <div class="d-flex justify-content-center mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End Form -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white mt-5">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Developer By Ali Albanna 2025</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

    <script>
    document.getElementById('profileImageUpload').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const target = document.querySelector(this.getAttribute('data-target'));
                if (target.type === 'password') {
                    target.type = 'text';
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    target.type = 'password';
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });
    </script>
</body>
</html>
