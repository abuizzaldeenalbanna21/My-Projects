<?php
ob_start();
session_start();
include "database.php";

$userType = $_SESSION['user_type'] ?? '';
$name = $_SESSION['name'] ?? '';
$id = $_SESSION['id'] ?? '';

$db = new Database($conn);

// التأكد أن المستخدم طبيب
if ($userType !== "doctor") {
    die("Unauthorized access.");
}

// جلب بيانات الطبيب
$dataProfile = $db->select("doctors", "id=?", [$id]);
$dataProfile = $dataProfile ? $dataProfile[0] : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $specialty = $_POST['specialty'] ?? $dataProfile['specialty'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];

    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // معالجة الصورة
    if (!empty($_FILES['profile_image']['name'])) {
        $image_name = time() . '_' . basename($_FILES['profile_image']['name']);
        $target_path = "uploads/" . $image_name;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_path);
    } else {
        $image_name = $dataProfile['profile_image'] ?? '';
    }

    // تحديث كلمة المرور إذا تم إدخال جديد
    if (!empty($new_password)) {
        if ($new_password !== $confirm_password) {
            echo "<p style='color:red;'>كلمة المرور الجديدة غير متطابقة.</p>";
        } else {
            $encoded_password = base64_encode($new_password); // ⚠️ للتجربة فقط
            $sql = "UPDATE doctors SET full_name = :full_name, specialty = :specialty, phone = :phone, email = :email, birthday = :birthday, profile_image = :profile_image, password = :password WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'full_name' => $full_name,
                'specialty' => $specialty,
                'phone' => $phone,
                'email' => $email,
                'profile_image' => $image_name,
                'password' => $encoded_password,
                'id' => $id
            ]);
        }
    } else {
        // بدون تغيير كلمة المرور
        $sql = "UPDATE doctors SET full_name = :full_name, specialty = :specialty, phone = :phone, email = :email, profile_image = :profile_image WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'full_name' => $full_name,
            'specialty' => $specialty,
            'phone' => $phone,
            'email' => $email,
            'profile_image' => $image_name,
            'id' => $id
        ]);
    }

    echo "<p style='color:green;'>تم تحديث البيانات بنجاح.</p>";

    // تحديث بيانات العرض
    $stmt = $conn->prepare("SELECT * FROM doctors WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $dataProfile = $stmt->fetch(PDO::FETCH_ASSOC);
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

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3 mb-4 text-gray-800">Profile</h1>
                            <a href="index_admin.php" class="btn btn-circle btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>

                        <div class="row">
                            

                            <!-- Start Form -->
                            <div class="col-lg-8">
                                <form class="card shadow p-4" method="POST" enctype="multipart/form-data">
                                    <h5 class="card-title mb-3">Edit Your Information</h5>

                                    <div class="col-lg-12 text-center">
                                <div class="card shadow mb-4">
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

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="userName">User Name</label>
                                            <input type="text" name="full_name" value="<?= htmlspecialchars($dataProfile['full_name']) ?>" class="form-control" id="userName" placeholder="Enter your user name">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="userEmail">Email</label>
                                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($dataProfile['email']) ?>" id="userEmail" placeholder="Enter your email">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="userBirthday">Birthday</label>
                                            <input type="date" name="birthday" class="form-control" value="<?//= htmlspecialchars($dataProfile['birth_date']) ?>" id="userBirthday">
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
                                                <input type="password" name="current_password" class="form-control" value="" id="currentPassword" placeholder="Enter current password">
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

                                    <!-- Save Button -->
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- End Form -->
                        </div>

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
